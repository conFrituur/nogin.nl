<?php

readonly class State
{
    /**
     * @var Person[] $persons
     */
    private array $persons;

    /**
     * @param Person[] $persons
     */
    public function __construct(array $persons)
    {
        $this->persons = $persons;
    }

    public function getPersons(): array
    {
        return $this->persons;
    }

    public function findPerson(Person $personToFind): ?Person
    {
        return array_find($this->getPersons(), fn($person) => $person->equals($personToFind));
    }

    public function findPersonByName(string $name): ?Person
    {
        return $this->findPerson(new Person($name));
    }

    public function updatePerson(Person $updatedPerson): self
    {
        $updatedPersons = [];
        foreach ($this->getPersons() as $person) {
            $updatedPersons[] = $person->equals($updatedPerson) ? $updatedPerson : $person;
        }
        return new self($updatedPersons);
    }

    public function updatePersonsFromState(State $updatedState): self
    {
        $updatedPersons = [];
        foreach ($this->getPersons() as $person) {
            $updatedPerson    = $updatedState->findPerson($person);
            $updatedPersons[] = $updatedPerson ?? $person;
        }
        return new self($updatedPersons);
    }

    public function toArray(): array
    {
        $stateArray = [];
        foreach ($this->getPersons() as $person) {
            $stateArray[] = $person->toArray();
        }
        return $stateArray;
    }

    public static function fromArray(array $stateArray): self
    {
        $persons = [];
        foreach ($stateArray as $personArray) {
            $persons[] = Person::fromArray($personArray);
        }
        return new self($persons);
    }

    public static function fromListOfNames(array $listOfNames): self
    {
        $persons = [];
        foreach ($listOfNames as $name) {
            $persons[] = new Person($name);
        }
        return new self($persons);
    }
}
