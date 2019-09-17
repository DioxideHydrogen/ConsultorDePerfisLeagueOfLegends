<?php declare(strict_types=1);

namespace ProfessorJamesBach;

class Champion
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getId(): int
    {
        return $this->data['championId'];
    }

    public function getIconUrl(string $name): string
    {
        return "https://ddragon.leagueoflegends.com/cdn/9.15.1/img/champion/$name.png";
    }

    public function getLevel(): int
    {
        return $this->data['championLevel'];
    }

    public function getPoints(): int
    {
        return $this->data['championPoints'];
    }
}