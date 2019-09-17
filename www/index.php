<?php declare(strict_types=1);

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use ProfessorJamesBach\Riot;
use ProfessorJamesBach\Server;
use ProfessorJamesBach\ServerCollection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$basedir = __DIR__;
require_once "$basedir/../vendor/autoload.php";

$env = Dotenv::create("$basedir/../");
$env->load();
$env->required('RIOT_APIKEY');

$twig = new Environment(new FilesystemLoader("$basedir/../templates"));
$riot = new Riot(new Client(['verify' => false]), getenv('RIOT_APIKEY'));

$servers = (new ServerCollection())
    ->addServer(new Server ('br1'))
    ->addServer(new Server ('ru'))
    ->addServer(new Server ('kr'))
    ->addServer(new Server ('oc1'))
    ->addServer(new Server ('jp1'))
    ->addServer(new Server ('na1'))
    ->addServer(new Server ('eun1'))
    ->addServer(new Server ('euw1'))
    ->addServer(new Server ('tr1'))
    ->addServer(new Server ('la1'))
    ->addServer(new Server ('la2'));

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === '/summoner' && $method === 'POST') {
    $server = strtolower(filter_input(INPUT_POST, 'server'));
    $summoner_name = filter_input(INPUT_POST, 'summoner');

    if ($servers->exists($server)) {
        $summoner = $riot->getSummonerByName($server, $summoner_name);
        $rank = $riot->getRankBySummonerId($server, $summoner->getId());
        $masteries = $riot->getMasteriesBySummonerId($server, $summoner->getId());

        echo $twig->render('summoner.twig', ['summoner' => $summoner, 'rank' => $rank, 'masteries' => $masteries, 'riot' => $riot]);

        exit();
    }
}

echo $twig->render('index.twig', ['servers' => $servers]);