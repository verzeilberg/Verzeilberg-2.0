<?php

namespace Application\Entity;

use Application\Model\UnityOfWork;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;

/**
 * This class represents a menu item.
 * @ORM\Entity()
 * @ORM\Table(name="menuitems")
 */
class MenuItem extends UnityOfWork {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Label"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Label"})
     */
    protected string $label;

    /**
     * @var string
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Link"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Link"})
     */
    protected string $link;

    /**
     * @var string
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Icon"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Icon"})
     */
    protected string $icon;

    /**
     * @var string
     * @ORM\Column(name="menu_id", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Id"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Id"})
     */
    protected string $menuId;

    /**
     * @var string
     * @ORM\Column(name="autorized_for", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Authorized for"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Authorized for"})
     */
    protected string $authorizedFor;

    /**
     * One MenuItem has Many MenuItems.
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="parent")
     */
    private $children;

    /**
     * Many MenuItems have One MenuItem.
     * @ORM\ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     *
     */
    private $parent;



    public function __construct() {
        $this->children = new ArrayCollection();

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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getMenuId(): string
    {
        return $this->menuId;
    }

    /**
     * @param string $menuId
     */
    public function setMenuId(string $menuId): void
    {
        $this->menuId = $menuId;
    }

    /**
     * @return string
     */
    public function getAuthorizedFor(): string
    {
        return $this->authorizedFor;
    }

    /**
     * @param string $authorizedFor
     */
    public function setAuthorizedFor(string $authorizedFor): void
    {
        $this->authorizedFor = $authorizedFor;
    }



    /**
     * @return ArrayCollection
     */
    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     */
    public function setChildren(ArrayCollection $children): void
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

}
