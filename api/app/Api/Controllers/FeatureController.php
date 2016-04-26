<?php

namespace Api\Controllers;

use Api\Repositories\Contracts\FeatureRepositoryInterface;
use Api\Requests\Feature\CreateRequest;
use Api\Requests\Feature\GetRequest;
use Api\Requests\Feature\UpdateRequest;
use Api\Transformers\FeatureTransformer;

class FeatureController extends BaseController
{
    /**
     * @var Api\Repositories\Contracts\FeatureRepositoryInterface
     */
    protected $repository;

    public function __construct(FeatureRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve feature list
     * @param  Api\Requests\Feature\GetRequest $request
     * @return array
     */
    public function index(GetRequest $request)
    {
        $query_params = $request->filters('limit', 'page', 'from', 'to', 'order');
        $features    = $this->repository->paginate($query_params);

        return $this->paginator($features, new FeatureTransformer);
    }

    /**
     * Retrieve a feature by object id
     * @param  string $id
     * @return array
     */
    public function show($id)
    {
        return $this->item($this->repository->find($id)->get(), new FeatureTransformer);
    }

    /**
     * Create a new feature
     * @param  CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request)
    {
        return $this->item($this->repository->create($request->input()), new FeatureTransformer);
    }

    /**
     * Update feature by feature id
     * @param  UpdateRequest $request
     * @param  int $id
     * @return int
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->repository->find($id)->update($request->input());
    }

    /**
     * Delete feature by feature id
     * @param  int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
