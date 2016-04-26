<?php

namespace Api\Repositories;

use Carbon\Carbon;

use App\Models\User;
use Api\Repositories\Contracts\RepositoryInterface as RepositoryInterface;
use Api\Repositories\Contracts\UserRepositoryInterface as UserRepositoryInterface;
use Api\Repositories\Eloquent\Repository as EloquentRepository;

class UserRepository extends EloquentRepository implements RepositoryInterface, UserRepositoryInterface
{
    /**
     * User eloquent object
     * @var App\Models\User
     */
    protected $eloquent;

    /**
     * User object
     * @var App\Models\User
     */
    private $eloquent_object;

    public function __construct(User $eloquent)
    {
        $this->eloquent        = $eloquent;
        $this->eloquent_object = $eloquent;
    }

    /**
     * Retrieve a user collection with pagination object
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
     * Find a specific user by attribute
     * @param  string $id
     * @param  string $attribute
     * @return App\Models\User;
     */
    public function find($id, $attribute = '_id')
    {
        $this->eloquent_object = $this->eloquent->where($attribute, '=', $id);

        return $this;
    }

    /**
     * Get a user object
     * @return array
     */
    public function get()
    {
        return $this->eloquent_object->firstOrFail();
    }

    /**
     * Create a new user
     * @param  array $data
     * @return array
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * Update user
     * @param  array $data
     * @return int
     */
    public function update(array $data)
    {
        return $this->eloquent_object->update($data);
    }

    /**
     * Delete user by object id
     * @param  $id
     * @return int
     */
    public function delete($id)
    {
        return $this->eloquent->destroy($id);
    }
}
