<?php

namespace Application\Service;

use Laminas\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class defaultService implements defaultServiceInterface
{

    private $entityManager;
    private $entity;
    private $searchColumns = [];


    /**
     *
     * Set entityManager
     * @param entityManager $entityManager
     *
     * @return void
     *
     */
    protected function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Set entity
     * @param entity $entity
     *
     * @return void
     *
     */
    protected function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     *
     * Set searchColumns
     * @param array $searchColumns
     *
     * @return array
     *
     */
    protected function setSearchColumns(array $searchColumns)
    {
        $this->searchColumns = $searchColumns;
    }

    /**
     *
     * Get item object by on id
     *
     * @param       id $id The id to fetch the item from the database
     * @return      object
     *
     */
    public function getItem($id)
    {
        $item = $this->entityManager->getRepository($this->entity)
            ->findOneBy(['id' => $id], []);

        return $item;
    }


    /**
     *
     * Get array of items
     *
     * @return      array
     *
     */
    public function getItems()
    {

        $items = $this->entityManager->getRepository($this->entity)
            ->findBy(['deletedAt' => null], ['createdAt' => 'DESC']);

        return $items;
    }

    /**
     *
     * Get array of languages  for pagination
     * @var $query query
     * @var $currentPage current page
     * @var $itemsPerPage items on a page
     *
     * @return      array
     *
     */
    public function getItemsForPagination($query, $currentPage = 1, $itemsPerPage = 10)
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($itemsPerPage);
        $paginator->setCurrentPageNumber($currentPage);
        return $paginator;
    }

    /**
     *
     * Get array of items
     * @var $searchString string to search for
     *
     * @return      array
     *
     */
    public function searchItems($searchString)
    {
        $result = [];
        $qb = $this->entityManager->getRepository($this->entity)->createQueryBuilder('e');
        $orX = $qb->expr()->orX();
        if (count($this->searchColumns) > 0) {
            foreach ($this->searchColumns as $column) {
                $orX->add($qb->expr()->like('e.' . $column, $qb->expr()->literal("%$searchString%")));
            }
            $qb->where($orX);
            $query = $qb->getQuery();
            $result = $query->getResult();
        }
        return $result;
    }

    /**
     *
     * Create form of an object
     *
     * @param       item $item object
     * @return      form
     *
     */
    public function createForm($item)
    {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($item);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, $this->entity));
        $form->bind($item);
        return $form;
    }

    /**
     *
     * Create a new item object
     * @return      object
     *
     */
    public function newItem()
    {
        $item = new $this->entity();
        return $item;
    }

    /**
     *
     * Save a item to the database
     * @param       item $item object
     * @param       user $user object
     * @return      void
     *
     */
    public function saveItem($item)
    {
        $this->storeItem($item);
    }

    /**
     *
     * Update a item in database
     * @param       item $item object
     * @param       user $user object
     * @return      void
     *
     */
    public function updateItem($item)
    {
        $this->storeItem($item);
    }


    /**
     *
     * Save a item to database
     * @param       item $item object
     * @return      void
     *
     */
    public function storeItem($item)
    {
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a item from the database
     * @param       item $item object
     * @return      void
     *
     */
    public function deleteItem($item)
    {
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

}
