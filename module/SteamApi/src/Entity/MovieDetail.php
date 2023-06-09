<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a movie detail item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_games_movies_details")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class MovieDetail extends UnityOfWork {

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
     * @ORM\Column(name="thumbnail", type="string", length=255, nullable=true)
     */
    protected string $thumbnail;

    /**
     * Many Movie details have Many Games.
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="movieDetails")
     * @var Collection<int, Game>
     */
    private Collection $games;

    /**
     * Many Movie details have Many movies.
     * @ORM\ManyToMany(targetEntity="Movie")
     * @ORM\JoinTable(name="movie_details_movie",
     *      joinColumns={@ORM\JoinColumn(name="movie_detail_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id", unique=true)}
     *      )
     * @var Collection<int, Movie>
     */
    private Collection $movies;

    public function __construct() {
        $this->games  = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

}
