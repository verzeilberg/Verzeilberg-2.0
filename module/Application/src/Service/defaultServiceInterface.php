<?php

namespace Application\Service;

interface defaultServiceInterface
{

    /**
     *
     * Get item object by on id
     *
     * @param       id $id The id to fetch the item from the database
     * @return      object
     *
     */
    public function getItem($id);

    /**
     *
     * Get array of items
     *
     * @return      array
     *
     */
    public function getItems();

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
    public function getItemsForPagination($query, $currentPage = 1, $itemsPerPage = 10);

    /**
     *
     * Get array of items
     * @var $searchString string to search for
     *
     * @return      array
     *
     */
    public function searchItems($searchString);

    /**
     *
     * Create form of an object
     *
     * @param       item $item object
     * @return      form
     *
     */
    public function createForm($item);

    /**
     *
     * Create a new item object
     * @return      object
     *
     */
    public function newItem();

    /**
     *
     * Save a item to the database
     * @param       item $item object
     * @param       user $user object
     * @return      void
     *
     */
    public function saveItem($item);

    /**
     *
     * Update a item in database
     * @param       item $item object
     * @param       user $user object
     * @return      void
     *
     */
    public function updateItem($item);


    /**
     *
     * Save a item to database
     * @param       item $item object
     * @return      void
     *
     */
    public function storeItem($item);

    /**
     *
     * Delete a item from the database
     * @param       item $item object
     * @return      void
     *
     */
    public function deleteItem($item);
}
