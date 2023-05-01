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

class steamGameService
{
    /** @var array */
    protected array $config;
    /** @var string */
    protected string $url;

    const API_SERVICE = 'IPlayerService';

    public function __construct() {
        $this->createUrl();
    }

    private function createUrl()
    {
        $this->url = 'https://store.steampowered.com/api/appdetails?appids=';
    }

    /**
     * @param $appId
     * @return mixed
     */
    public function getGameDetail($appId)
    {
        return json_decode(file_get_contents(sprintf($this->url. '%d',$appId)));
    }

}
