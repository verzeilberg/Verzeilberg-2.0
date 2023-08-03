<?php

namespace SteamApi\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam movie item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_game_movies")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Movie extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="format", type="string", length=255, nullable=false)
     */
    protected string $format;

    /**
     * @ORM\Column(name="quality", type="string", length=255, nullable=true)
     */
    protected string $quality;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected string $url;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Movie
     */
    public function setId(int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return Movie
     */
    public function setFormat(string $format): Movie
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuality(): string
    {
        return $this->quality;
    }

    /**
     * @param string $quality
     * @return Movie
     */
    public function setQuality(string $quality): Movie
    {
        $this->quality = $quality;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Movie
     */
    public function setUrl(string $url): Movie
    {
        $this->url = $url;
        return $this;
    }



}
