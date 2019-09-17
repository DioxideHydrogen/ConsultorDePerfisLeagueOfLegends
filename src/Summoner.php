<?php declare(strict_types=1);

namespace ProfessorJamesBach;

class Summoner
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getLevel(): int
    {
        return $this->data['summonerLevel'];
    }

    public function getProfileIconUrl(): string
    {
        return "https://static.teemo.gg/league-of-legends/9.17/profile-icons/{$this->data['profileIconId']}.jpg";
    }

    public function getId(): string
    {
        return $this->data['id'];
    }
}