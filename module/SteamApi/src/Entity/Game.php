<?php

namespace SteamApi\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam game item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_games")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class Game extends UnityOfWork {


    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(name="appid", type="integer", length=11, unique=false, nullable=false)
     */
    protected int $appId;

    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    protected string $type;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected string $name;

    /**
     * @ORM\Column(name="detailed_description", type="text", nullable=true)
     */
    protected string $detailedDescription;

    /**
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    protected string $shortDescription;

    /**
     * @ORM\Column(name="about_the_game", type="text", nullable=true)
     */
    protected string $aboutTheGame;

    /**
     * @ORM\Column(name="header_image", type="string", length=255, nullable=true)
     */
    protected string $headerImage;

    /**
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    protected string $website;

    /**
     * One game has many user game details. This is the inverse side.
     * @var Collection<int, Feature>
     * @ORM\OneToMany(targetEntity="UserGameDetail", mappedBy="game")
     */
    private Collection $userGameDetails;

    /**
     * Many Games have Many Categories.
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="games")
     * @ORM\JoinTable(name="games_categories")
     * @var Collection<int, Category>
     */
    private Collection $categories;

    /**
     * Many Games have Many Genres.
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="games")
     * @ORM\JoinTable(name="games_genres")
     * @var Collection<int, Genre>
     */
    private Collection $genres;

    /**
     * Many Games have Many Developers.
     * @ORM\ManyToMany(targetEntity="Developer", inversedBy="games")
     * @ORM\JoinTable(name="games_developers")
     * @var Collection<int, Developer>
     */
    private Collection $developers;

    /**
     * Many Games have Many Publishers.
     * @ORM\ManyToMany(targetEntity="Publisher", inversedBy="games")
     * @ORM\JoinTable(name="games_publishers")
     * @var Collection<int, Publisher>
     */
    private Collection $publishers;

    /**
     * Many Games have Many Screenshots.
     * @ORM\ManyToMany(targetEntity="Screenshot", inversedBy="games")
     * @ORM\JoinTable(name="games_screenshots")
     * @var Collection<int, Screenshot>
     */
    private Collection $screenshots;

    /**
     * Many Games have Many Movies details.
     * @ORM\ManyToMany(targetEntity="MovieDetail", inversedBy="games")
     * @ORM\JoinTable(name="games_movie_detail")
     * @var Collection<int, MovieDetail>
     */
    private Collection $movieDetails;

    public function __construct() {
        $this->userGameDetails  = new ArrayCollection();
        $this->categories       = new ArrayCollection();
        $this->genres           = new ArrayCollection();
        $this->developers       = new ArrayCollection();
        $this->publishers       = new ArrayCollection();
        $this->screenshots      = new ArrayCollection();
        $this->movieDetails     = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->appId;
    }

    /**
     * @param int $appId
     * @return Game
     */
    public function setAppId(int $appId): Game
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Game
     */
    public function setType(string $type): Game
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Game
     */
    public function setName(string $name): Game
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetailedDescription(): string
    {
        return $this->detailedDescription;
    }

    /**
     * @param string $detailedDescription
     * @return Game
     */
    public function setDetailedDescription(string $detailedDescription): Game
    {
        $this->detailedDescription = $detailedDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return Game
     */
    public function setShortDescription(string $shortDescription): Game
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getAboutTheGame(): string
    {
        return $this->aboutTheGame;
    }

    /**
     * @param string $aboutTheGame
     * @return Game
     */
    public function setAboutTheGame(string $aboutTheGame): Game
    {
        $this->aboutTheGame = $aboutTheGame;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeaderImage(): string
    {
        return $this->headerImage;
    }

    /**
     * @param string $headerImage
     * @return Game
     */
    public function setHeaderImage(string $headerImage): Game
    {
        $this->headerImage = $headerImage;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Game
     */
    public function setWebsite(string $website): Game
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getUserGameDetails(): Collection
    {
        return $this->userGameDetails;
    }

    /**
     * @param Collection $userGameDetails
     * @return Game
     */
    public function setUserGameDetails(Collection $userGameDetails): Game
    {
        $this->userGameDetails = $userGameDetails;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     * @return Game
     */
    public function setCategories(Collection $categories): Game
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    /**
     * @param Collection $genres
     * @return Game
     */
    public function setGenres(Collection $genres): Game
    {
        $this->genres = $genres;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getDevelopers(): Collection
    {
        return $this->developers;
    }

    /**
     * @param Collection $developers
     * @return Game
     */
    public function setDevelopers(Collection $developers): Game
    {
        $this->developers = $developers;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getPublishers(): Collection
    {
        return $this->publishers;
    }

    /**
     * @param Collection $publishers
     * @return Game
     */
    public function setPublishers(Collection $publishers): Game
    {
        $this->publishers = $publishers;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getScreenshots(): Collection
    {
        return $this->screenshots;
    }

    /**
     * @param Collection $screenshots
     * @return Game
     */
    public function setScreenshots(Collection $screenshots): Game
    {
        $this->screenshots = $screenshots;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getMovieDetails(): Collection
    {
        return $this->movieDetails;
    }

    /**
     * @param Collection $movieDetails
     * @return Game
     */
    public function setMovieDetails(Collection $movieDetails): Game
    {
        $this->movieDetails = $movieDetails;
        return $this;
    }

}
