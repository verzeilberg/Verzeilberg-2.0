<?php

namespace Application\Entity;

use Application\Model\UnityOfWork;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;

/**
 * This class represents a menu item.
 * @ORM\Entity(repositoryClass="Application\Repository\MenuRepository")
 * @ORM\Table(name="menu")
 */
class Menu extends UnityOfWork {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Naam"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected string $name;

    /**
     * @ORM\ManyToMany(targetEntity="MenuItem")
     * @ORM\JoinTable(name="menu_menuitems",
     *      joinColumns={@ORM\JoinColumn(name="menu_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="item_id", referencedColumnName="id")}
     *      )
     */
    private $menuItems;



    public function __construct() {
        $this->menuItems = new ArrayCollection();
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Assigns a role to user.
     */
    public function addMenuItem($menuItem)
    {
        $this->menuItems->add($menuItem);
    }

    public function getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     * @param ArrayCollection $menuItems
     */
    public function setMenuItems(ArrayCollection $menuItems): void
    {
        $this->menuItems = $menuItems;
    }


}
