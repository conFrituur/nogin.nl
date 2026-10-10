<?php

class Repository
{
    private const string PEOPLE_FILE = 'people.json';
    private const string STATE_FILE = 'state.json';
    private const string STATE_LOCKFILE = 'state.lock';

    private State $state;

    public function __construct()
    {
        $this->state = new State([]);
        $this->loadState();
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function findPerson(string $name): ?Person
    {
        return $this->state->findPersonByName($name);
    }

    public function updatePersonInState(string $name, bool $isNogInNL): void
    {
        $this->state = $this->getState()->updatePerson(new Person($name, $isNogInNL));
    }

    private function loadState(): void
    {
        $stateArray = [];

        if (file_exists(self::STATE_FILE)) {
            $stateContents = file_get_contents(self::STATE_FILE);
            $stateArray    = json_decode($stateContents, true);
        }

        if (!is_array($stateArray) || count($stateArray) === 0) {
            $this->syncPeopleWithState();
        } else {
            try {
                $this->state = State::fromArray($stateArray);
            } catch (Throwable) {
                $this->syncPeopleWithState();
            }
        }
    }

    private function syncPeopleWithState(): void
    {
        if (file_exists(self::PEOPLE_FILE)) {
            $peopleContents = file_get_contents(self::PEOPLE_FILE);
            $personsInList  = json_decode($peopleContents, true);

            if (!is_array($personsInList) || count($personsInList) === 0) {
                return;
            }
        } else {
            return;
        }

        $desiredState = State::fromListOfNames($personsInList);
        $this->state = $desiredState->updatePersonsFromState($this->getState());
    }

    public function saveState(): bool
    {
        $lock = fopen(self::STATE_LOCKFILE, 'c');

        if ($lock === false || !flock($lock, LOCK_EX)) {
            return false;
        }

        $this->syncPeopleWithState();

        try {
            $newContents = json_encode(
                $this->getState()->toArray(),
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
            return false;
        } finally {
            flock($lock, LOCK_UN);
            fclose($lock);
        }

        return true;
    }
}
