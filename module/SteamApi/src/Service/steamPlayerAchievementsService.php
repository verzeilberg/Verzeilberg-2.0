<?php

namespace SteamApi\Service;

use DateTime;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Exception;
use Laminas\Form\Annotation\AnnotationBuilder;
use Laminas\Log\Logger;
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
        // make request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, sprintf($this->url. '%d',$appId));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        // convert response
        $output = json_decode($output);

        // handle error; error output
        if(curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            //$logger = new Logger();
            //$logger->addWriter('stream', null, ['stream' => 'php://output']);
            //$logger->info(sprintf('Game achievements with appId: %s not imported!', $appId));
            return null;
        }
        curl_close($ch);
        return $output;
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
