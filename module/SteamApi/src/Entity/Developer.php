<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam developer item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_developers")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Developer extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected int $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @var string
     */
    protected string $name;

    /**
     * Many Developers have Many Games.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="developers")
     * @var Collection<int, Game>
     */
    private Collection $games;

    public function __construct() {
        $this->games = new ArrayCollection();
    }

}
