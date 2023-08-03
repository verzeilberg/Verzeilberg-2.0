<?php

namespace SteamApi\Entity;

use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a steam user game details item.
 * @ORM\Entity()
 * @ORM\Table(name="steam_user_game_details")
 * @Annotation\Hydrator("Laminas\Hydrator\ObjectPropertyHydrator")
 */
class UserGameDetail extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * Playtime in minutes
     * @ORM\Column(name="playtime_forever", type="integer", length=11, nullable=true)
     */
    protected int $playtimeForever;

    /**
     * @ORM\Column(name="time_last_played", type="integer", length=255, nullable=true)
     */
    protected int $timeLastPlayed;

    /**
     * Many User game details have one game. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="userGameDetails")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private Game|null $game = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserGameDetail
     */
    public function setId(int $id): UserGameDetail
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlaytimeForever(): int
    {
        return $this->playtimeForever;
    }

    /**
     * @param int $playtimeForever
     * @return UserGameDetail
     */
    public function setPlaytimeForever(int $playtimeForever): UserGameDetail
    {
        $this->playtimeForever = $playtimeForever;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeLastPlayed(): int
    {
        return $this->timeLastPlayed;
    }

    /**
     * @param int $timeLastPlayed
     * @return UserGameDetail
     */
    public function setTimeLastPlayed(int $timeLastPlayed): UserGameDetail
    {
        $this->timeLastPlayed = $timeLastPlayed;
        return $this;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        return $this->game;
    }

    /**
     * @param Game|null $game
     * @return UserGameDetail
     */
    public function setGame(?Game $game): UserGameDetail
    {
        $this->game = $game;
        return $this;
    }



}
