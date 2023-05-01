<?php

namespace SteamApi\Service;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
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
use Symfony\Component\VarDumper\VarDumper;

class steamGameStatsService
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
        $this->url = sprintf('%s/%s/GetUserStatsForGame/%s/?key=%s&steamid=%ss&appid=',
            $this->config['steamApi']['url'],
            self::API_SERVICE,
            'v0002',
            $this->config['steamApi']['Steam-Web-API-key'],
            $this->config['steamApi']['Steam-id']
        );
    }

    /**
     * @param $appId
     * @return mixed
     */
    public function getGameStats($appId)
    {
        return json_decode(file_get_contents(sprintf($this->url. '%d',$appId)));
    }

}
