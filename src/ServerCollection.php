<?php declare(strict_types=1);

namespace ProfessorJamesBach;

class ServerCollection
{
    /** @var Server[] */
    private $collection;

    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    public function addServer(Server $server): self
    {
        $this->collection[$server->getKey()] = $server;
        return $this;
    }

    /** @return string[] */
    public function getKeys(): array
    {
        return array_keys($this->collection);
    }

    public function exists(string $server): bool
    {
        return array_key_exists($server, $this->collection);
    }
}