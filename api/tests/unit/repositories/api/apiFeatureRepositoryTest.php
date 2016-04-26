<?php

use Carbon\Carbon;

use Api\Repositories\FeatureRepository;

class apiFeatureRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->mock_model      = Mockery::mock('Moloquent', 'App\Models\Feature');
        $this->mock_repository = new FeatureRepository($this->mock_model);
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
    public function should_return_eloquent_collection_instance_when_try_to_get_all_feature()
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
    public function should_return_eloquent_collection_instance_when_try_to_get_all_feature_by_pagination_method()
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
    public function should_return_instance_of_itself_when_get_specific_feature_by_id()
    {
        $random_id = rand();

        $this->mock_model->shouldReceive('where')
                         ->with('_id', '=', $random_id)
                         ->once()
                         ->andReturn(new Api\Repositories\FeatureRepository($this->mock_model));

        $actual = $this->mock_repository->find($random_id);

        $this->assertInstanceOf('Api\Repositories\FeatureRepository', $actual);
    }

    /**
     * @test
     */
    public function should_return_feature_model_instance_when_call_get_feature()
    {
        $this->mock_model->shouldReceive('firstOrFail')
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->get();

        $this->assertInstanceOf('App\Models\Feature', $actual);
    }

    /**
     * @test
     */
    public function should_return_feature_model_instance_when_create_a_new_feature()
    {
        $params = [
            'name'         => 'Deangelo Kassulke',
            'display_name' => 'Dr. Dalton Lebsack Jr.',
            'description'  => 'Atque ipsum quod fuga vel aut.',
        ];

        $this->mock_model->shouldReceive('create')
                         ->with($params)
                         ->once()
                         ->andReturnSelf();

        $actual = $this->mock_repository->create($params);

        $this->assertInstanceOf('App\Models\Feature', $actual);
    }

    /**
     * @test
     */
    public function should_return_integer_when_update_feature_successful()
    {
        $params = [
            'name'         => 'Deangelo Kassulke',
            'display_name' => 'Dr. Dalton Lebsack Jr.',
            'description'  => 'Atque ipsum quod fuga vel aut.',
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
    public function should_return_integer_when_delete_feature_successful()
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
