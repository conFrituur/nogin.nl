<?php

readonly class Person
{
    private string $name;
    private bool $isNogInNL;

    public function __construct(string $name, bool $isNogInNL = true)
    {
        if (strlen($name) === 0) {
            throw new RuntimeException('Name cannot be empty.');
        }

        $this->name      = strtolower($name);
        $this->isNogInNL = $isNogInNL;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isNogInNL(): bool
    {
        return $this->isNogInNL;
    }

    public static function fromArray(array $personArray): self
    {
        $name      = $personArray["name"] ?? null;
        $isNogInNL = $personArray["isNogInNL"] ?? null;

        if (!$name) {
            throw new RuntimeException("Missing name for Person");
        }

        if ($isNogInNL === null) {
            return new self($name);
        }

        return new self($name, $isNogInNL);
    }

    public function toArray(): array
    {
        return [
            'name'      => $this->getName(),
            'isNogInNL' => $this->isNogInNL(),
        ];
    }

    public function equals(Person $person): bool
    {
        return $person->getName() === $this->getName();
    }
}
