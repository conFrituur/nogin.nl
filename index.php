<?php

$vhost = $_SERVER['HTTP_HOST'];

if(preg_match('/^is([a-z]+)\.nogin\.nl$/', $vhost, $nameMatch)) {
    $name = $nameMatch[1];
    if(isInNl($name)) {
        require 'templates/nogin.php';
    } else {
        require 'templates/nietin.php';
    }
} else {
    require 'templates/index.html';
}

function isInNl(string $name): bool {
    $stateFile = __DIR__ . '/state.json';
    $state = [];
    if (file_exists($stateFile)) {
        $stateContents = file_get_contents($stateFile);
        $state = json_decode($stateContents, true);

        if (!is_array($state)) {
           return true;
        }
        return $state[$name] ?? true;
    }

    return true;
}
