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
    protected integer $id;

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

}
