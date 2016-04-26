<?php

namespace Api\Repositories;

use Carbon\Carbon;

use App\Models\Customer;
use Api\Repositories\Contracts\RepositoryInterface as RepositoryInterface;
use Api\Repositories\Contracts\CustomerRepositoryInterface as CustomerRepositoryInterface;
use Api\Repositories\Eloquent\Repository as EloquentRepository;

class CustomerRepository extends EloquentRepository implements RepositoryInterface, CustomerRepositoryInterface
{
    /**
     * Customer eloquent object
     * @var App\Models\Customer
     */
    protected $eloquent;

    /**
     * Customer object
     * @var App\Models\Customer
     */
    private $eloquent_object;

    public function __construct(Customer $eloquent)
    {
        $this->eloquent        = $eloquent;
        $this->eloquent_object = $eloquent;
    }

    /**
     * Retrieve a customer collection with pagination object
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
     * Find a specific customer by attribute
     * @param  string $id
     * @param  string $attribute
     * @return App\Models\Customer;
     */
    public function find($id, $attribute = '_id')
    {
        $this->eloquent_object = $this->eloquent->where($attribute, '=', $id);

        return $this;
    }

    /**
     * Get a customer object
     * @return array
     */
    public function get()
    {
        return $this->eloquent_object->firstOrFail();
    }

    /**
     * Create a new customer
     * @param  array $data
     * @return array
     */
    public function create(array $data)
    {
        return $this->eloquent->create($data);
    }

    /**
     * Update customer
     * @param  array $data
     * @return int
     */
    public function update(array $data)
    {
        return $this->eloquent_object->update($data);
    }

    /**
     * Delete customer by object id
     * @param  $id
     * @return int
     */
    public function delete($id)
    {
        return $this->eloquent->destroy($id);
    }

    /**
     * Add features to customer
     * @param  array $features
     * @return array
     */
    public function addFeatures($features)
    {
        $customer = $this->eloquent_object->firstOrFail();

        foreach ($features as $feature) {
            if (empty($customer->features)) {
                $customer->push('features', $feature);
            } elseif (!in_array($feature, $customer->features)) {
                $customer->push('features', $feature);
            }
        }

        return $customer->fresh();
    }
}
