<?php

namespace SteamApi\Service;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
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
     * @return void
     */
    public function getGameDetail($appId)
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
            $logger = new Logger();
            $logger->addWriter('stream', null, ['stream' => 'php://output']);
            $logger->info(sprintf('Game detail with appId: %s not imported!', $appId));
            return null;
        }
        curl_close($ch);
        return $output;
    }

}
