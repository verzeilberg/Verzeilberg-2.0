<?php

namespace SteamApi\Service;

use DateTime;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Exception;
use Laminas\Form\Annotation\AnnotationBuilder;
use Laminas\ServiceManager\ServiceLocatorInterface;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Laminas\Paginator\Paginator;
use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;

/*
 * Entities
 */

use Blog\Entity\Blog;
use Symfony\Component\Console\Helper\Dumper;
use Symfony\Component\VarDumper\VarDumper;

class steamPlayerService
{
    /** @var array */
    protected array $config;
    /** @var string */
    protected string $url;
    /** @var  */
    protected $steamGameService;
    /** @var  */
    protected $steamGameStatsService;

    const API_SERVICE = 'IPlayerService';

    public function __construct($config, $steamGameService, $steamGameStatsService) {
        $this->config               = $config;
        $this->steamGameService   = $steamGameService;
        $this->steamGameStatsService   = $steamGameStatsService;

        $this->createUrl();
    }

    private function createUrl()
    {
        $this->url = sprintf('%s/%s/GetOwnedGames/%s/?key=%s&steamid=%s&format=%s&include_appinfo=1',
            $this->config['steamApi']['url'],
            self::API_SERVICE,
            $this->config['steamApi']['version'],
            $this->config['steamApi']['Steam-Web-API-key'],
            $this->config['steamApi']['Steam-id'],
            $this->config['steamApi']['format']
        );
    }

    /**
     * @param int $count
     * @return array
     * @throws Exception
     */
    public function getOwnedGames(int $count = 0): array
    {
        $content = json_decode(file_get_contents($this->url));
        $games = $content->response->games;

        usort($games, function($a, $b) {
            return $a->playtime_forever <=> $b->playtime_forever;
        });

        $games = array_reverse($games);
        if ($count > 0) {
            $games = array_slice($games, 0, $count);
        }

        $result = [];
        foreach ($games as $index => $game) {
            $gameDetail = $this->steamGameService->getGameDetail($game->appid);
            $gameStats = $this->steamGameStatsService->getPlayerAchievements($game->appid);
            $gameAchievements =  $this->steamGameStatsService->getAchievementsStats($gameStats->playerstats->achievements);
            $appId = $game->appid;
            $result[$index]['name'] = $gameDetail->$appId->data->name;
            $result[$index]['image'] = $gameDetail->$appId->data->header_image;
            $result[$index]['genres'] = $this->getGenres($gameDetail->$appId->data->genres);
            $result[$index]['play_time'] = $this->getHoursPlayed($game->playtime_forever);
            $result[$index]['last_played'] = $this->getLastPlayed($game->rtime_last_played);
            $result[$index]['achievements'] = $gameAchievements;
        }
        return $result;
    }

    /**
     * @param $minutes
     * @return float
     */
    private function getHoursPlayed($minutes)
    {
        return round($minutes/60, 1);
    }

    /**
     * @param $timeStamp
     * @return string
     * @throws Exception
     */
    private function getLastPlayed($timeStamp): string
    {
        $date = new DateTime();
        $date->setTimestamp($timeStamp);
        return $date->format('Y/m/d');

    }

    /**
     * @param $genres
     * @return string
     */
    private function getGenres($genres): string
    {
        $result = '';
        foreach ($genres as $index => $genre) {
            if ($index !== 0) {
                $result = $result . ', ' . $genre->description;
            } else {
                $result = $result . $genre->description;
            }
        }

        return $result;
    }

}
