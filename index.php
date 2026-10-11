<?php
require_once "autoload.php";
$repository = new Repository();

$vhost = $_SERVER['HTTP_HOST'];

if(preg_match('/^is([a-z]+)\.nogin\.nl$/', $vhost, $nameMatch)) {
    $name = $nameMatch[1]; // $name is used in template
    $person = $repository->findPerson($name);
    // default to in NL
    if($person === null || $person->isNogInNL()) {
        require 'templates/nogin.php';
    } else {
        require 'templates/nietin.php';
    }
} else {
    require 'templates/index.html';
}
