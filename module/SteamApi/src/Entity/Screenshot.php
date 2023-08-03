<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a screenshot item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_games_screenshots")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Screenshot extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="path_thumbnail", type="string", length=255, nullable=true)
     */
    protected string $pathThumbnail;

    /**
     * @ORM\Column(name="path_full", type="string", length=255, nullable=true)
     */
    protected string $pathFull;

    /**
     * Many Screenshots have Many Games.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="screenshots")
     * @var Collection<int, Game>
     */
    private Collection $games;

    public function __construct() {
        $this->games = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Screenshot
     */
    public function setId(int $id): Screenshot
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathThumbnail(): string
    {
        return $this->pathThumbnail;
    }

    /**
     * @param string $pathThumbnail
     * @return Screenshot
     */
    public function setPathThumbnail(string $pathThumbnail): Screenshot
    {
        $this->pathThumbnail = $pathThumbnail;
        return $this;
    }

    /**
     * @return string
     */
    public function getPathFull(): string
    {
        return $this->pathFull;
    }

    /**
     * @param string $pathFull
     * @return Screenshot
     */
    public function setPathFull(string $pathFull): Screenshot
    {
        $this->pathFull = $pathFull;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    /**
     * @param Collection $games
     * @return Screenshot
     */
    public function setGames(Collection $games): Screenshot
    {
        $this->games = $games;
        return $this;
    }

}
