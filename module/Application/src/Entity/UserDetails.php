<?php

namespace Application\Entity;

use Application\Model\UnityOfWork;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;
use Laminas\Validator\Date;
use User\Entity\User;

/**
 * This class represents a user detail item.
 * @ORM\Entity(repositoryClass="Application\Repository\UserDetailsRepository")
 * @ORM\Table(name="user_details")
 */
class UserDetails extends UnityOfWork {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected string $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected string $lastName;

    /**
     * @var DateTime
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    protected DateTime $birthDate;

    /**
     * @var string
     * @ORM\Column(name="bio", type="text", nullable=true)
     */
    protected string $bio;

    /**
     * @var string
     * @ORM\Column(name="catch_line", type="string", length=255, nullable=true)
     */
    protected string $catchLine;


    /** One UserDetail has one User.
     * @ORM\ManyToMany(targetEntity="User\Entity\User")
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     */
    private User|null $user = null;


    public function __construct() {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getBirthDate(): string
    {
        return $this->birthDate;
    }

    public function setBirthDate(string $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getCatchLine(): string
    {
        return $this->catchLine;
    }

    public function setCatchLine(string $catchLine): void
    {
        $this->catchLine = $catchLine;
    }


}
