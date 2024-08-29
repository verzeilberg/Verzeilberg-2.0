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
    /** @var */
    protected steamGameService $steamGameService;
    /** @var */
    protected steamPlayerAchievementsService $steamGameStatsService;

    const API_SERVICE = 'IPlayerService';

    public function __construct($config, $steamGameService, $steamGameStatsService)
    {
        $this->config = $config;
        $this->steamGameService = $steamGameService;
        $this->steamGameStatsService = $steamGameStatsService;

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
     * @param int $offset
     * @param int $returnTotalGames
     * @return array
     * @throws Exception
     */
    public function getOwnedGames(int $count = 0, int $offset = 0, int $returnTotalGames = 0): array|int
    {
        $content = json_decode(file_get_contents($this->url));
        $games = $content->response->games;

        if ($returnTotalGames === 1) {
            return count($games);
        }

        usort($games, function ($a, $b) {
            return $a->playtime_forever <=> $b->playtime_forever;
        });


        $games = array_reverse($games);

        if ($count > 0) {
            $games = array_slice($games, $offset, $count);
        }

        $result = [];
        foreach ($games as $index => $game) {
            $appId = $game->appid;
            $result[$index]['game']['appId'] = $appId;
            $result[$index]['game']['name'] = $game->name;
            $result[$index]['user_game_detail']['play_time_forever'] = $this->getHoursPlayed($game->playtime_forever);
            $result[$index]['user_game_detail']['time_last_played'] = $this->getLastPlayed($game->rtime_last_played);
            //Get game details by app id
            $gameDetail = $this->steamGameService->getGameDetail($appId);
            if ($gameDetail->$appId->success) {
                $result[$index]['game']['type'] = $gameDetail->$appId->data->type;
                $result[$index]['game']['detailed_description'] = $gameDetail->$appId->data->detailed_description;
                $result[$index]['game']['short_description'] = $gameDetail->$appId->data->short_description;
                $result[$index]['game']['about_the_game'] = $gameDetail->$appId->data->about_the_game;
                $result[$index]['game']['header_image'] = $gameDetail->$appId->data->header_image;
                $result[$index]['game']['website'] = $gameDetail->$appId->data->website;
                //Get categories
                if (isset($gameDetail->$appId->data->categories)) {
                    foreach($gameDetail->$appId->data->categories as $catIndex => $categorie) {
                        $result[$index]['categories'][$catIndex]['id'] = $categorie->id;
                        $result[$index]['categories'][$catIndex]['description'] = $categorie->description;
                    }
                }
                //Get genres
                if (isset($gameDetail->$appId->data->genres)) {
                    foreach($gameDetail->$appId->data->genres as $genIndex => $genre) {
                        $result[$index]['genres'][$genIndex]['id'] = $genre->id;
                        $result[$index]['genres'][$genIndex]['description'] = $genre->description;
                    }
                }
                //Get developers
                if (isset($gameDetail->$appId->data->developers)) {
                    foreach($gameDetail->$appId->data->developers as $devIndex => $developer) {
                        $result[$index]['developers'][$devIndex]['developer'] = $developer;
                    }
                }
                //Get publishers
                if (isset($gameDetail->$appId->data->publishers)) {
                    foreach($gameDetail->$appId->data->publishers as $pubIndex => $publisher) {
                        $result[$index]['publishers'][$pubIndex]['publisher'] = $publisher;
                    }
                }
                //Get screenshots
                if (isset($gameDetail->$appId->data->screenshots)) {
                    foreach($gameDetail->$appId->data->screenshots as $screenIndex => $screenshot) {
                        $result[$index]['screenshots'][$screenIndex]['id'] = $screenshot->id;
                        $result[$index]['screenshots'][$screenIndex]['path_thumbnail'] = $screenshot->path_thumbnail;
                        $result[$index]['screenshots'][$screenIndex]['path_full'] = $screenshot->path_full;
                    }
                }
                //Get movies
                if (isset($gameDetail->$appId->data->movies)) {
                    foreach($gameDetail->$appId->data->movies as $movieIndex => $movie) {
                        $result[$index]['movies'][$movieIndex]['id'] = $movie->id;
                        $result[$index]['movies'][$movieIndex]['name'] = $movie->name;
                        $result[$index]['movies'][$movieIndex]['thumbnail'] = $movie->thumbnail;
                        //webmovie
                        $quality480 = 480;
                        if (isset($movie->webm)) {
                            $result[$index]['movies'][$movieIndex]['webm']['480'] = $movie->webm->$quality480;
                            $result[$index]['movies'][$movieIndex]['webm']['max'] = $movie->webm->max;
                        }
                        //mp4
                        if (isset($movie->mp4)) {
                            $result[$index]['movies'][$movieIndex]['mp4']['480'] = $movie->mp4->$quality480;
                            $result[$index]['movies'][$movieIndex]['mp4']['max'] = $movie->mp4->max;
                        }
                    }
                }
            }
            $gameStats = $this->steamGameStatsService->getPlayerAchievements($game->appid);
            $gameAchievements = [];
            if ($gameStats !== null && isset($gameStats->playerstats) && isset($gameStats->playerstats->achievements)) {
                $gameAchievements = $this->steamGameStatsService->getAchievementsStats($gameStats->playerstats->achievements);
            }
            $result[$index]['achievements'] = $gameAchievements;
            sleep(2);
        }
        return $result;
    }

    /**
     * @param $minutes
     * @return float
     */
    private function getHoursPlayed($minutes)
    {
        return round($minutes / 60, 1);
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
    }
}