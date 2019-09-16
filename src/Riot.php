<?php declare(strict_types=1);

namespace ProfessorJamesBach;

use GuzzleHttp\Client;

class Riot
{
    /** @var Client */
    private $client;
    /** @var string */
    private $apiKey;
    /** @var array */
    private $champions;

    public function __construct(Client $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getSummonerByName(string $server, string $summonerName): Summoner
    {
        $url = "https://$server.api.riotgames.com/lol/summoner/v4/summoners/by-name/$summonerName?api_key={$this->apiKey}";
        return new Summoner($this->clientGetAndJsonDecode($url));
    }

    public function getRankBySummonerId(string $server, string $summonerId): Rank
    {
        $url = "https://$server.api.riotgames.com/lol/league/v4/entries/by-summoner/$summonerId?api_key={$this->apiKey}";
        return new Rank($this->clientGetAndJsonDecode($url));
    }

    public function getMasteriesBySummonerId(string $server, string $summonerId): Masteries
    {
        $url = "https://$server.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/$summonerId?api_key={$this->apiKey}";
        return new Masteries($this->clientGetAndJsonDecode($url));
    }

    private function clientGetAndJsonDecode(string $url): array
    {
        $response = $this->client->get($url);
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getChampionNameById(int $id): string
    {
        if ($this->champions === null) {
            $this->champions = $this->getChampions();
        }

        return $this->champions[$id]['name'];
    }

    public function getChampionKeyById(int $id): string
    {
        if ($this->champions === null) {
            $this->champions = $this->getChampions();
        }

        return $this->champions[$id]['id'];
    }

    private function getChampions(): array
    {
        $url = "http://ddragon.leagueoflegends.com/cdn/9.7.1/data/en_US/champion.json";
        $data = $this->clientGetAndJsonDecode($url);

        return array_reduce($data['data'], function (array $champions, array $champion) {
             $champions[intval($champion['key'])] = $champion;
             return $champions;
        }, []);
    }
}