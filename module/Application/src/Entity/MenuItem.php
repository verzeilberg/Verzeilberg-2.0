<?php

namespace Application\Entity;

use Application\Model\UnityOfWork;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Form\Annotation;

/**
 * This class represents a menu item.
 * @ORM\Entity(repositoryClass="Application\Repository\MenuItemRepository")
 * @ORM\Table(name="menuitems")
 */
class MenuItem extends UnityOfWork {

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected ?int $id = null;

    /**
     * @var string
     * @ORM\Column(name="label", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Label"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Label"})
     */
    protected ?string $label = null;

    /**
     * @var ?string
     * @ORM\Column(name="link", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Link"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Link"})
     */
    protected ?string $link = null;

    /**
     * @var string
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Icon"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Icon"})
     */
    protected ?string $icon = null;

    /**
     * @var integer
     * @ORM\Column(name="sort_order", type="integer", length=10, nullable=false)
     */
    protected int $sortOrder = 9999;

    /**
     * @var string
     * @ORM\Column(name="menu_id", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Id"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Id"})
     */
    protected ?string $menuId = null;

    /**
     * @var string
     * @ORM\Column(name="autorized_for", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Authorized for"
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Authorized for"})
     */
    protected ?string $authorizedFor = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): void
    {
        $this->label = $label;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): void
    {
        $this->icon = $icon;
    }

    public function getSortOrder(): int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): void
    {
        $this->sortOrder = $sortOrder;
    }

    public function getMenuId(): ?string
    {
        return $this->menuId;
    }

    public function setMenuId(?string $menuId): void
    {
        $this->menuId = $menuId;
    }

    public function getAuthorizedFor(): ?string
    {
        return $this->authorizedFor;
    }

    public function setAuthorizedFor(?string $authorizedFor): void
    {
        $this->authorizedFor = $authorizedFor;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren($children): void
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getParent(): mixed
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent(mixed $parent): void
    {
        $this->parent = $parent;
    }
}
