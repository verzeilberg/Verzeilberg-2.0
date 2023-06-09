<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam game category item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_categories")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Category extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11, unique=true)
     */
    protected int $id;

    /**
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    protected string $description;

    /**
     * Many Categories have Many Games.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="categories")
     * @var Collection<int, Game>
     */
    private Collection $games;

    public function __construct() {
        $this->games = new ArrayCollection();
    }

}
