<?php

namespace Api\Repositories;

use Carbon\Carbon;

use App\Models\Feature;
use Api\Repositories\Contracts\RepositoryInterface as RepositoryInterface;
use Api\Repositories\Contracts\FeatureRepositoryInterface as FeatureRepositoryInterface;
use Api\Repositories\Eloquent\Repository as EloquentRepository;

class FeatureRepository extends EloquentRepository implements RepositoryInterface, FeatureRepositoryInterface
{
    /**
     * Feature eloquent object
     * @var App\Models\Feature
     */
    protected $eloquent;

    /**
     * Feature object
     * @var App\Models\Feature
     */
    private $eloquent_object;

    public function __construct(Feature $eloquent)
    {
        $this->eloquent        = $eloquent;
        $this->eloquent_object = $eloquent;
    }

    /**
     * Retrieve a feature collection with pagination object
     * @param  array filter
     * @return mixed
     */
    public function paginate($filter = array('*'))
    {
        return $this->eloquent->where('created_at', '>', Carbon::parse($filter['from']))
                              ->where('created_at', '<', Carbon::parse($filter['to']))
                              ->paginate($filter['limit']);
    }

    /**
     * Find a specific feature by attribute
     * @param  string $id
     * @param  string $attribute
     * @return App\Models\Feature;
     */
    public function find($id, $attribute = '_id')
    {
        $this->eloquent_object = $this->eloquent->where($attribute, '=', $id);

        return $this;
    }

    /**
     * Get a feature object
     * @return array
     */
    public function get()
    {
        return $this->eloquent_object->firstOrFail();
    }

    /**
     * Create a new feature
     * @param  array $data
     * @return array
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * Update feature
     * @param  array $data
     * @return int
     */
    public function update(array $data)
    {
        return $this->eloquent_object->update($data);
    }

    /**
     * Delete feature by object id
     * @param  $id
     * @return int
     */
    public function delete($id)
    {
        return $this->eloquent->destroy($id);
    }
}
