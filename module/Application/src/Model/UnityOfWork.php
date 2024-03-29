<?php

namespace Application\Model;

use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Laminas\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Doctrine\ORM\EntityManager;

class UnityOfWork extends EntityManager
{



    /**
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     * @Annotation\Exclude()
     * @var datetime
     */
    protected DateTime $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     * @var object
     */
    protected object $createdBy;

    /**
     * @ORM\Column(name="date_changed", type="datetime", nullable=true)
     * @var datetime
     */
    protected DateTime $dateChanged;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     * @var object
     */
    protected object $changedBy;

    /**
     * @ORM\Column(name="date_deleted", type="datetime", nullable=true)
     * @var datetime
     */
    protected DateTime $dateDeleted;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="deleted_by", referencedColumnName="id")
     * @var object
     */
    protected object $deletedBy;

    /**
     * @ORM\Column(name="deleted", type="integer", length=1, nullable=true)
     */
    protected int|null $deleted;

    /**
     * @return DateTime|null
     */
    public function getDateCreated(): ? DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param datetime $dateCreated
     * @return UnityOfWork
     */
    public function setDateCreated(DateTime $dateCreated): UnityOfWork
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return object|null
     */
    public function getCreatedBy(): ? object
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
     * @return DateTime|null
     */
    public function getDateChanged(): ? DateTime
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
     * @return object|null
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
     * @return DateTime|null
     */
    public function getDateDeleted(): ?DateTime
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
    public function getDeleted(): ? int
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
