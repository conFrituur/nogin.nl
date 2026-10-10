<?php
// Load every .php file in the same directory as this file.
foreach (glob(__DIR__ . '/src/*.php') as $file) {
    if ($file !== __FILE__) {
        require_once $file;
    }
}
