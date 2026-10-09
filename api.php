<?php

class NoginNLApi
{
    private const string PEOPLE_FILE = __DIR__ . '/people.json';
    private const string STATE_FILE = __DIR__ . '/state.json';
    private const string STATE_LOCKFILE = __DIR__ . '/state.lock';
    private array $state = [];

    public function __construct()
    {
        $this->loadState();
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path   = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // strip of api.php if url /api.php/persons is directly used.
        if (str_starts_with($path, 'api.php')) {
            $path = trim(substr($path, 7),'/');
        }

        if ($path === '' ) {
            require "templates/api.html";
            exit();
        }

        header('Content-Type: application/json');

        $parts  = explode('/', $path);
        if ($parts[0] !== 'persons') {
            $this->respond(['error' => 'Route not found'], 404);
        }

        if ($method === 'GET' && count($parts) === 1) {
            $this->listPersons();
        }

        if (count($parts) === 2) {
            $name = strtolower($parts[1]); // names all lowercase

            if ($method === 'GET') {
                $this->getPerson($name);
            }

            if ($method === 'PATCH' || $method === 'PUT') {
                $this->updatePerson($name);
                $this->getPerson($name);
            }
        }

        $this->respond(['error' => 'Route or method not found'], 404);
    }

    private function listPersons(): never
    {
        $this->respond($this->state);
    }

    private function getPerson(string $name): never
    {
        $this->respond($this->findPerson($name));
    }

    private function updatePerson(string $name): void
    {
        $this->findPerson($name);

        $rawBody = file_get_contents('php://input');
        if (strlen($rawBody) > 1000) {
            $this->respond(['error' => 'body too large'], 400);
        }

        $body = json_decode(file_get_contents('php://input'), true);

        if (!is_array($body)) {
            $this->respond(['error' => 'Update body is not an array'], 400);
        }
        if (!isset($body['isNogInNL'])) {
            $this->respond(['error' => 'isNogInNL is missing from update array'], 400);
        }
        if (!is_bool($body['isNogInNL'])) {
            $this->respond(['error' => 'isNogInNL is not a boolean value'], 400);
        }

        $updatedPersonList = [];
        foreach ($this->state as $personState) {
            if ($personState['name'] === $name) {
                $updatedPersonList[] = ['name' => $name, 'isNogInNL' => $body['isNogInNL']];
            } else {
                $updatedPersonList[] = $personState;
            }
        }

        $this->state = $updatedPersonList;
        $this->saveState();
    }

    private function findPerson(string $name): array
    {
        $returnPerson = null;
        foreach ($this->state as $personState) {
            if ($personState['name'] === $name) {
                $returnPerson = $personState;
            }
        }

        if ($returnPerson === null) {
            $this->respond(['error' => 'Person not found'], 404);
        }

        return $returnPerson;
    }

    private function respond(array|bool $data, int $status = 200): never
    {
        http_response_code($status);
        echo json_encode($data);
        exit();
    }

    private function loadState(): void
    {
        if (file_exists(self::STATE_FILE)) {
            $stateContents = file_get_contents(self::STATE_FILE);
            $state         = json_decode($stateContents, true);

            if (!is_array($state) || count($state) === 0) {
                $this->syncPeopleWithState();
            }

            foreach ($state as $name => $isNogInNL) {
                $this->state[] = ['name' => $name, 'isNogInNL' => $isNogInNL];
            }
        } else {
            $this->syncPeopleWithState();
        }
    }

    private function syncPeopleWithState(): void
    {
        if (file_exists(self::PEOPLE_FILE)) {
            $peopleContents = file_get_contents(self::PEOPLE_FILE);
            $people         = json_decode($peopleContents, true);

            if (!is_array($people) || count($people) === 0) {
                return;
            }
        } else {
            return;
        }

        $statePeopleList = [];
        foreach ($this->state as $statePerson) {
            $statePeopleList[] = $statePerson['name'];
        }

        $personsToRemove = array_diff($statePeopleList, $people);
        $personsToAdd = array_diff($people, $statePeopleList);

        $updatedState = [];
        foreach ($this->state as $person) {
            if (!in_array($person['name'], $personsToRemove)) {
                $updatedState[] = $person;
            };
        }
        foreach ($personsToAdd as $name) {
            $updatedState[] = ['name' => strtolower($name), 'isNogInNL' => true];
        }

        $this->state = $updatedState;
    }

    private function saveState(): void
    {
        $lock = fopen(self::STATE_LOCKFILE, 'c');

        if ($lock === false || !flock($lock, LOCK_EX)) {
            http_response_code(500);
            $this->respond(['error' => 'Could not acquire lock to save'], 500);
        }

        $this->syncPeopleWithState();

        $legacyFormattedState = [];
        foreach ($this->state as $personState) {
            $legacyFormattedState[$personState['name']] = $personState['isNogInNL'];
        }

        try {
            $newContents = json_encode(
                $legacyFormattedState,
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

            if ($written === false || !chmod($temporaryFile, 0775) || !rename($temporaryFile, self::STATE_FILE)) {
                @unlink($temporaryFile);
                throw new RuntimeException('Could not replace state file');
            }

        } catch (Throwable) {
            $this->respond(['error' => 'Could not save state'], 500);
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }
    }
}

$api = new NoginNLApi();
$api->handleRequest();
