<?php

use Mockery as Mockery;

use Api\Controllers\FeatureController;
use Api\Requests\Feature\CreateRequest;
use Api\Requests\Feature\GetRequest;
use Api\Requests\Feature\UpdateRequest;

class apiFeatureControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');

        $this->mock_repository = Mockery::mock('Api\Repositories\Contracts\FeatureRepositoryInterface');
        $this->mock_controller = new FeatureController($this->mock_repository);
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');

        Mockery::close();
    }

    /**
     * @test
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists($this->mock_controller, 'index'));
        $this->assertTrue(method_exists($this->mock_controller, 'show'));
        $this->assertTrue(method_exists($this->mock_controller, 'store'));
        $this->assertTrue(method_exists($this->mock_controller, 'update'));
        $this->assertTrue(method_exists($this->mock_controller, 'destroy'));
    }

    /**
     * @test
     */
    public function should_return_error_object_when_try_to_create_feature_without_required_fields()
    {
        $expected                    = array();
        $expected['name'][0]         = "The name field is required.";
        $expected['display_name'][0] = "The display name field is required.";
        $expected['description'][0]  = "The description field is required.";

        $request_params = array();

        $request   = new CreateRequest();
        $rules     = $request->rules();
        $validator = Validator::make($request_params, $rules);

        $this->assertTrue($validator->fails());
        $this->assertEquals($expected, $validator->messages()->getMessages());
    }

    /**
     * @test
     */
    public function should_return_error_object_when_try_to_create_feature_that_has_already_been_using_unique_values()
    {
        $expected             = array();
        $expected['name'][0]  = "The name has already been taken.";

        $factory = factory(App\Models\Feature::class)->create([
            'name'         => 'Deangelo Kassulke',
            'display_name' => 'Dr. Dalton Lebsack Jr.',
            'description'  => 'Atque ipsum quod fuga vel aut.',
        ]);

        $request_params = [
            'name'         => 'Deangelo Kassulke',
            'display_name' => 'Dr. Dalton Lebsack Jr.',
            'description'  => 'Atque ipsum quod fuga vel aut.',
        ];

        $request   = new CreateRequest();
        $rules     = $request->rules();
        $validator = Validator::make($request_params, $rules);

        $this->assertTrue($validator->fails());
        $this->assertEquals($expected, $validator->messages()->getMessages());
    }

    /**
     * @test
     */
    public function should_return_error_object_when_try_to_update_feature_without_required_fields()
    {
        $expected                    = array();
        $expected['name'][0]         = "The name field is required.";
        $expected['display_name'][0] = "The display name field is required.";
        $expected['description'][0]  = "The description field is required.";

        $request_params = array();

        $request   = new UpdateRequest();
        $rules     = $request->rules();
        $validator = Validator::make($request_params, $rules);

        $this->assertTrue($validator->fails());
        $this->assertEquals($expected, $validator->messages()->getMessages());
    }

    /**
     * @test
     */
    public function should_return_zero_integer_when_try_to_delete_empty_feature()
    {
        $random_id = rand();

        $this->mock_repository->shouldReceive('delete')
                              ->with($random_id)
                              ->once()
                              ->andReturn(0);

        $actual = $this->mock_controller->destroy($random_id);

        $this->assertEquals(0, $actual);
    }
}
