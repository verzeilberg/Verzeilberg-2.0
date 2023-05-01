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

class steamPlayerAchievementsService
{
    /** @var array */
    protected array $config;
    /** @var string */
    protected string $url;

    const API_SERVICE = 'ISteamUserStats';

    public function __construct($config) {
        $this->config               = $config;

        $this->createUrl();
    }

    private function createUrl()
    {
        $this->url = sprintf('%s/%s/GetPlayerAchievements/%s/?key=%s&steamid=%s&appid=',
            $this->config['steamApi']['url'],
            self::API_SERVICE,
            $this->config['steamApi']['version'],
            $this->config['steamApi']['Steam-Web-API-key'],
            $this->config['steamApi']['Steam-id'],
            $this->config['steamApi']['format']
        );
    }

    public function getPlayerAchievements($appId)
    {
        return json_decode(file_get_contents(sprintf($this->url. '%d',$appId)));
    }

    /**
     * @param $achievements
     * @return int[]
     */
    public function getAchievementsStats($achievements): array
    {
        $totalAchievements = 0;
        $totalFinishedAchievements = 0;
        foreach($achievements as $achievement)
        {
            $totalAchievements++;
            if ($achievement->achieved === 1) {
                $totalFinishedAchievements++;
            }
        }

        return [
            'totalAchievements' => $totalAchievements,
            'totalFinishedAchievements' => $totalFinishedAchievements
        ];

    }


}
