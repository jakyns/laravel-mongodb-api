<?php

use Carbon\Carbon;

use Api\Repositories\CustomerRepository;

class apiCustomerRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock_model      = Mockery::mock('Moloquent', 'App\Models\Customer');
        $this->mock_repository = new CustomerRepository($this->mock_model);
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
    public function should_return_eloquent_collection_instance_when_try_to_get_all_customer()
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
    public function should_return_eloquent_collection_instance_when_try_to_get_all_customer_by_pagination_method()
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
    public function should_return_instance_of_itself_when_get_specific_customer_by_id()
    {
        $random_id = rand();

        $this->mock_model->shouldReceive('where')
                         ->with('_id', '=', $random_id)
                         ->once()
                         ->andReturn(new Api\Repositories\CustomerRepository($this->mock_model));

        $actual = $this->mock_repository->find($random_id);

        $this->assertInstanceOf('Api\Repositories\CustomerRepository', $actual);
    }

    /**
     * @test
     */
    public function should_return_customer_model_instance_when_call_get_customer()
    {
        $this->mock_model->shouldReceive('firstOrFail')
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->get();

        $this->assertInstanceOf('App\Models\Customer', $actual);
    }

    /**
     * @test
     */
    public function should_return_customer_model_instance_when_create_a_new_customer()
    {
        $params = [
            'name'        => 'Rebeka Champlin',
            'description' => 'Alias magni similique porro quo quisquam quia eaque.',
            'email'       => 'hblock@example.org',
        ];

        $this->mock_model->shouldReceive('create')
                         ->with($params)
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->create($params);

        $this->assertInstanceOf('App\Models\Customer', $actual);
    }

    /**
     * @test
     */
    public function should_return_integer_when_update_customer_successful()
    {
        $params = [
            'name'        => 'Rebeka Champlin',
            'description' => 'Alias magni similique porro quo quisquam quia eaque.',
            'email'       => 'hblock@example.org',
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
    public function should_return_integer_when_delete_customer_successful()
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
