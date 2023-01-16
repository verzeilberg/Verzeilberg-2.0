<?php

namespace Application\Model;

use Laminas\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

class UnityOfWork
{

    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var datetime
     */
    protected $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * @var object
     */
    protected $createdBy;

    /**
     * @ORM\Column(name="date_changed", type="datetime", nullable=true)
     * @var datetime
     */
    protected $dateChanged;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     * @var object
     */
    protected $changedBy;

    /**
     * @ORM\Column(name="date_deleted", type="datetime", nullable=true)
     * @var datetime
     */
    protected $dateDeleted;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="deleted_by", referencedColumnName="id")
     * @var object
     */
    protected $deletedBy;

    /**
     * @ORM\Column(name="deleted", type="integer", length=1, nullable=true)
     * @var integer
     */
    protected $deleted = 0;

    /**
     * @return string
     */
    public function getDateCreated(): ? string
    {
        return $this->dateCreated;
    }

    /**
     * @param datetime $dateCreated
     * @return UnityOfWork
     */
    public function setDateCreated($dateCreated): UnityOfWork
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return object
     */
    public function getCreatedBy(): ? sobject
    {
        return $this->createdBy;
    }

    /**
     * @param $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy): UnityOfWork
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateChanged(): ?string
    {
        return $this->dateChanged;
    }

    /**
     * @param $dateChanged
     * @return $this|null
     */
    public function setDateChanged($dateChanged): ?UnityOfWork
    {
        $this->dateChanged = $dateChanged;
        return $this;
    }

    /**
     * @return object
     */
    public function getChangedBy(): ? object
    {
        return $this->changedBy;
    }

    /**
     * @param $changedBy
     * @return UnityOfWork|null
     */
    public function setChangedBy($changedBy): ?UnityOfWork
    {
        $this->changedBy = $changedBy;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateDeleted(): ?string
    {
        return $this->dateDeleted;
    }

    /**
     * @param object|null $dateDeleted
     * @return UnityOfWork
     */
    public function setDateDeleted(?object $dateDeleted): UnityOfWork
    {
        $this->dateDeleted = $dateDeleted;
        return $this;
    }

    /**
     * @return object
     */
    public function getDeletedBy(): ? object
    {
        return $this->deletedBy;
    }

    /**
     * @param object|null $deletedBy
     * @return UnityOfWork
     */
    public function setDeletedBy(?object $deletedBy): UnityOfWork
    {
        $this->deletedBy = $deletedBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeleted(): int
    {
        return $this->deleted;
    }

    /**
     * @param int $deleted
     * @return UnityOfWork
     */
    public function setDeleted(int $deleted): UnityOfWork
    {
        $this->deleted = $deleted;
        return $this;
    }
}
