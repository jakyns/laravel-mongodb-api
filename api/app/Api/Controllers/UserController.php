<?php

namespace Api\Controllers;

use Api\Repositories\Contracts\UserRepositoryInterface;
use Api\Requests\User\CreateRequest;
use Api\Requests\User\GetRequest;
use Api\Requests\User\UpdateRequest;
use Api\Transformers\UserTransformer;

class UserController extends BaseController
{
    /**
     * @var Api\Repositories\Contracts\UserRepositoryInterface
     */
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve user list
     * @param  Api\Requests\User\GetRequest $request
     * @return array
     */
    public function index(GetRequest $request)
    {
        $query_params = $request->filters('limit', 'page', 'from', 'to', 'order');
        $users        = $this->repository->paginate($query_params);

        return $this->paginator($users, new UserTransformer);
    }

    /**
     * Retrieve a user by object id
     * @param  string $id
     * @return array
     */
    public function show($id)
    {
        return $this->item($this->repository->find($id)->get(), new UserTransformer);
    }

    /**
     * Create a new user
     * @param  CreateRequest $request
     * @return array
     */
    public function store(CreateRequest $request)
    {
        return $this->item($this->repository->create($request->input()), new UserTransformer);
    }

    /**
     * Update user by user id
     * @param  UpdateRequest $request
     * @param  int $id
     * @return int
     */
    public function update(UpdateRequest $request, $id)
    {
        return $this->repository->find($id)->update($request->input());
    }

    /**
     * Delete user by user id
     * @param  int $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->repository->delete($id);
    }
}
