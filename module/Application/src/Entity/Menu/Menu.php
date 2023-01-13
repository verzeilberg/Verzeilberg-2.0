<?php

namespace Application\Menu\Entity\Menu;

use Application\Model\UnityOfWork;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;

/**
 * This class represents a menu item.
 * @ORM\Entity()
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
     * Many menu's have many menu items
     * @ORM\ManyToMany(targetEntity="Application\Entity\MenuItem")
     * @ORM\JoinTable(name="menu_menuitems",
     *      joinColumns={@ORM\JoinColumn(name="menuId", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="menuItemId", referencedColumnName="id", unique=true, onDelete="CASCADE")}
     *      )
     */
    private ArrayCollection $menuItems;

    public function __construct() {
        $this->menuItems = new ArrayCollection();
    }

    /**
     * @param $menuItems
     * @return $this
     */
    public function addMenuItems($menuItems): Menu
    {
        if (!$this->menuItems->contains($menuItems)) {
            $this->menuItems->add($menuItems);
        }
        return $this;
    }

    /**
     * @param $menuItems
     * @return $this
     */
    public function removeMenuItem($menuItems): Menu
    {
        if ($this->menuItems->contains($menuItems)) {
            $this->menuItems->removeElement($menuItems);
        }
        return $this;
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
     * @return ArrayCollection
     */
    public function getMenuItems(): ArrayCollection
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
