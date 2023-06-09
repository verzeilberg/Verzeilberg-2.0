<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam publisher item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_publishers")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Publisher extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected string $name;

    /**
     * Many Publishers have Many Games.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="publishers")
     * @var Collection<int, Game>
     */
    private Collection $games;

    public function __construct() {
        $this->games = new ArrayCollection();
    }

}
