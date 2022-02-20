<?php

namespace Application\Model;

use Laminas\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

class UnityOfWork {

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
     * @return datetime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param datetime $dateCreated
     * @return UnityOfWork
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return object
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param object $createdBy
     * @return UnityOfWork
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return datetime
     */
    public function getDateChanged()
    {
        return $this->dateChanged;
    }

    /**
     * @param datetime $dateChanged
     * @return UnityOfWork
     */
    public function setDateChanged($dateChanged)
    {
        $this->dateChanged = $dateChanged;
        return $this;
    }

    /**
     * @return object
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * @param object $changedBy
     * @return UnityOfWork
     */
    public function setChangedBy($changedBy)
    {
        $this->changedBy = $changedBy;
        return $this;
    }

    /**
     * @return datetime
     */
    public function getDateDeleted()
    {
        return $this->dateDeleted;
    }

    /**
     * @param datetime $dateDeleted
     * @return UnityOfWork
     */
    public function setDateDeleted($dateDeleted)
    {
        $this->dateDeleted = $dateDeleted;
        return $this;
    }

    /**
     * @return object
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @param object $deletedBy
     * @return UnityOfWork
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param int $deleted
     * @return UnityOfWork
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }


}
