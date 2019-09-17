<?php declare(strict_types=1);

namespace ProfessorJamesBach;

class Rank
{
    const UNRANKED = 'UNRANKED';
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getTier(): string
    {
        return $this->data['tier'] ?? '';
    }

    public function getRank(): string
    {
        return $this->data['rank'] ?? self::UNRANKED;
    }

    public function getWins(): int
    {
        return $this->data['wins'] ?? 0;
    }

    public function getLosses(): int
    {
        return $this->data['losses'] ?? 0;
    }

    private function isUnranked(): bool
    {
        return empty($this->data['tier']) || empty($this->data['rank']);
    }

}