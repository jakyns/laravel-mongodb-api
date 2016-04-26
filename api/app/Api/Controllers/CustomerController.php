<?php

namespace Api\Controllers;

use Api\Repositories\Contracts\CustomerRepositoryInterface;
use Api\Requests\Customer\AddFeaturesRequest;
use Api\Requests\Customer\CreateRequest;
use Api\Requests\Customer\GetRequest;
use Api\Requests\Customer\UpdateRequest;
use Api\Transformers\CustomerTransformer;

class CustomerController extends BaseController
{
    /**
     * @var Api\Repositories\Contracts\CustomerRepositoryInterface
     */
    protected $repository;

    public function __construct(CustomerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve customer list
     * @param  Api\Requests\Customer\GetRequest $request
     * @return array
     */
    public function index(GetRequest $request)
    {
        $query_params = $request->filters('limit', 'page', 'from', 'to', 'order');
        $customers    = $this->repository->paginate($query_params);

        return $this->paginator($customers, new CustomerTransformer);
    }

    /**
     * Retrieve a customer by object id
     * @param  string $id
     * @return array
     */
    public function show($id)
    {
        return $this->item($this->repository->find($id)->get(), new CustomerTransformer);
    }

    /**
     * Create a new customer
     * @param  CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request)
    {
        return $this->item($this->repository->create($request->input()), new CustomerTransformer);
    }

    /**
     * Update customer by customer id
     * @param  UpdateRequest $request
     * @param  int $id
     * @return int
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->repository->find($id)->update($request->input());
    }

    /**
     * Delete customer by customer id
     * @param  int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Add features to customer (POST)
     * @param  Api\Requests\Customer\AddFeaturesRequest $request
     * @param  string $customer_id
     * @return array
     */
    public function addFeatures(AddFeaturesRequest $request, $customer_id)
    {
        $customer = $this->repository->find($customer_id)
                                     ->addFeatures($request->input('features_id'));

        return $customer;
    }
}
