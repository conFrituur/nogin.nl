<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Only POST requests are allowed'
    ]);
    exit;
}

$stateFile = __DIR__ . '/state.json';
$peopleFile = __DIR__ . '/people.json';
$lockFile = __DIR__ . '/state.lock';

$peopleJson = file_get_contents($peopleFile);

if ($peopleJson === false) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Could not read people file'
    ]);
    exit;
}

$allowedPeople = json_decode($peopleJson, true);

if (!is_array($allowedPeople)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid people file'
    ]);
    exit;
}

foreach ($allowedPeople as $person) {
    if (!is_string($person)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'People file must contain only names'
        ]);
        exit;
    }
}

$rawInput = file_get_contents('php://input');
if (strlen($rawInput) > 1000) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'input too large'
    ]);
    exit;
}

$input = json_decode(
    file_get_contents('php://input'),
    true
);

if (!is_array($input)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid JSON'
    ]);
    exit;
}

$person = $input['person'] ?? null;
$isInNL = $input['isInNL'] ?? null;

if (
    !is_string($person) ||
    !in_array($person, $allowedPeople, true)
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid person'
    ]);
    exit;
}

if (!is_bool($isInNL)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'isInNL must be true or false'
    ]);
    exit;
}

$lock = fopen($lockFile, 'c');

if ($lock === false || !flock($lock, LOCK_EX)) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Could not acquire file lock'
    ]);
    exit;
}

try {
    if (file_exists($stateFile)) {
        $stateContents = file_get_contents($stateFile);
        $state = json_decode($stateContents, true);

        if (!is_array($state)) {
            $state = [];
        }
    } else {
        $state = [];
    }

    $state[$person] = $isInNL;

    $newContents = json_encode(
        $state,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
    );

    if ($newContents === false) {
        throw new RuntimeException('Could not encode state');
    }

    $temporaryFile = tempnam(__DIR__, 'state-');

    if ($temporaryFile === false) {
        throw new RuntimeException('Could not create temporary file');
    }

    $written = file_put_contents(
        $temporaryFile,
        $newContents . PHP_EOL,
        LOCK_EX
    );

    if ($written === false || !chmod($temporaryFile, 0775) || !rename($temporaryFile, $stateFile)) {
        @unlink($temporaryFile);
        throw new RuntimeException('Could not replace state file');
    }

    echo json_encode([
        'success' => true,
        'person' => $person,
        'isInNL' => $isInNL
    ]);
} catch (Throwable $error) {
    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Could not save state'
    ]);
} finally {
    flock($lock, LOCK_UN);
    fclose($lock);
}
