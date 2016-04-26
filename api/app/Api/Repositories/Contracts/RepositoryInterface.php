<?php

namespace Api\Repositories\Contracts;

interface RepositoryInterface
{
    /**
     * Get object list
     * @return array
     */
    public function all();

    /**
     * Get object list
     * @param  array  $filter
     * @return array
     */
    public function paginate($filter = array('*'));

    /**
     * Find object by attribute
     * @param  string $id
     * @param  string $attribute
     * @return object
     */
    public function find($id, $attribute);

    /**
     * Get object
     * @return array
     */
    public function get();

    /**
     * Create object
     * @param  array $data
     * @return array
     */
    public function create(array $data);

    /**
     * Update object
     * @param  array  $data
     * @return int
     */
    public function update(array $data);

    /**
     * Delete object
     * @param  string $id
     * @return int
     */
    public function delete($id);
}
