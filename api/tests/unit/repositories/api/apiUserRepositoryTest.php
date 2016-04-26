<?php

use Carbon\Carbon;

use Api\Repositories\UserRepository;

class apiUserRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock_model      = Mockery::mock('Moloquent', 'App\Models\User');
        $this->mock_repository = new UserRepository($this->mock_model);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists($this->mock_repository, 'all'));
        $this->assertTrue(method_exists($this->mock_repository, 'paginate'));
        $this->assertTrue(method_exists($this->mock_repository, 'find'));
        $this->assertTrue(method_exists($this->mock_repository, 'get'));
        $this->assertTrue(method_exists($this->mock_repository, 'create'));
        $this->assertTrue(method_exists($this->mock_repository, 'update'));
        $this->assertTrue(method_exists($this->mock_repository, 'delete'));
    }

    /**
     * @test
     */
    public function should_return_eloquent_collection_instance_when_try_to_get_all_user()
    {
        $this->mock_model->shouldReceive('all')
                         ->once()
                         ->andReturn(new Illuminate\Database\Eloquent\Collection);

        $actual = $this->mock_repository->all();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $actual);
    }

    /**
     * @test
     */
    public function should_return_eloquent_collection_instance_when_try_to_get_all_user_by_pagination_method()
    {
        $filter = [
            'limit' => 20,
            'from'  => Carbon::yesterday(),
            'to'    => Carbon::today(),
            'order' => 'desc',
        ];

        $this->mock_model->shouldReceive('where')
                         ->twice()
                         ->andReturnSelf();

        $this->mock_model->shouldReceive('paginate')
                         ->once()
                         ->andReturn(new Illuminate\Pagination\LengthAwarePaginator($items = array(), $total = 20, $perPage = 20));

        $actual = $this->mock_repository->paginate($filter);

        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $actual);
    }

    /**
     * @test
     */
    public function should_return_instance_of_itself_when_get_specific_user_by_id()
    {
        $random_id = rand();

        $this->mock_model->shouldReceive('where')
                         ->with('_id', '=', $random_id)
                         ->once()
                         ->andReturn(new Api\Repositories\UserRepository($this->mock_model));

        $actual = $this->mock_repository->find($random_id);

        $this->assertInstanceOf('Api\Repositories\UserRepository', $actual);
    }

    /**
     * @test
     */
    public function should_return_user_model_instance_when_call_get_user()
    {
        $this->mock_model->shouldReceive('firstOrFail')
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->get();

        $this->assertInstanceOf('App\Models\User', $actual);
    }

    /**
     * @test
     */
    public function should_return_user_model_instance_when_create_a_new_user()
    {
        $params = [
            'firstname'             => 'Nicolette',
            'lastname'              => 'Robel',
            'email'                 => 'Wehner.Albert@example.net',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'country'               => 'TH',
        ];

        $this->mock_model->shouldReceive('create')
                         ->with($params)
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->create($params);

        $this->assertInstanceOf('App\Models\User', $actual);
    }

    /**
     * @test
     */
    public function should_return_integer_when_update_user_successful()
    {
        $params = [
            'firstname' => 'Nicolette',
            'lastname'  => 'Robel',
            'email'     => 'Wehner.Albert@example.net',
            'country'   => 'TH',
        ];

        $this->mock_model->shouldReceive('update')
                         ->with($params)
                         ->once()
                         ->andReturn(1);

        $actual = $this->mock_repository->update($params);

        $this->assertEquals(1, $actual);
    }

    /**
     * @test
     */
    public function should_return_integer_when_delete_user_successful()
    {
        $random_id = rand();

        $this->mock_model->shouldReceive('destroy')
                         ->with($random_id)
                         ->once()
                         ->andReturn(1);

        $actual = $this->mock_repository->delete($random_id);

        $this->assertEquals(1, $actual);
    }
}
