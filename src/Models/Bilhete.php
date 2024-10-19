<?php

declare(strict_types=1);

class Bilhete implements JsonSerializable
{
    private array $dezenas;

    public function __construct(array $dezenas)
    {
        sort($dezenas);
        $this->dezenas = $dezenas;
    }

    public function getDezenas(): array
    {
        return $this->dezenas;
    }

    public function jsonSerialize(): array
    {
        return [
            'dezenas' => $this->dezenas
        ];
    }

    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}