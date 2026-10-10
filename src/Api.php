<?php

class Api
{
    private Repository $repository;

    public function __construct()
    {
        $this->repository = new Repository();
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path   = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        // strip of api.php if url /api.php/persons is directly used.
        if (str_starts_with($path, 'api.php')) {
            $path = trim(substr($path, 7), '/');
        }

        if ($path === '') {
            require "templates/api.html";
            exit();
        }

        header('Content-Type: application/json');

        $parts = explode('/', $path);
        if ($parts[0] !== 'persons') {
            $this->response(['error' => 'Route not found'], 404);
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

        $this->response(['error' => 'Route or method not found'], 404);
    }

    private function listPersons(): never
    {
        $this->response($this->repository->getState()->toArray());
    }

    private function getPerson(string $name): never
    {
        $person = $this->findPerson($name);
        $this->response($person->toArray());
    }

    private function updatePerson(string $name): void
    {
        $this->findPerson($name);

        $rawBody = file_get_contents('php://input');
        if (strlen($rawBody) > 1000) {
            $this->response(['error' => 'body too large'], 400);
        }

        $body = json_decode(file_get_contents('php://input'), true);

        if (!is_array($body)) {
            $this->response(['error' => 'Update body is not an array'], 400);
        }
        if (!isset($body['isNogInNL'])) {
            $this->response(['error' => 'isNogInNL is missing from update array'], 400);
        }
        if (!is_bool($body['isNogInNL'])) {
            $this->response(['error' => 'isNogInNL is not a boolean value'], 400);
        }

        $this->repository->updatePersonInState($name, $body['isNogInNL']);

        if (!$this->repository->saveState()) {
            $this->response(['error' => 'Could update person state'], 500);
        }
    }

    private function findPerson(string $name): Person
    {
        $person = $this->repository->findPerson($name);

        if ($person === null) {
            $this->response(['error' => 'Person not found'], 404);
        }

        return $person;
    }

    private function response(array $data, int $status = 200): never
    {
        http_response_code($status);
        echo json_encode($data);
        exit();
    }
}
