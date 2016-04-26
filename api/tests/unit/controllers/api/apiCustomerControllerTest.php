<?php

use Mockery as Mockery;

use Api\Controllers\CustomerController;
use Api\Requests\Customer\AddFeaturesRequest;
use Api\Requests\Customer\CreateRequest;
use Api\Requests\Customer\GetRequest;
use Api\Requests\Customer\UpdateRequest;

class apiCustomerControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');

        $this->mock_repository = Mockery::mock('Api\Repositories\Contracts\CustomerRepositoryInterface');
        $this->mock_controller = new CustomerController($this->mock_repository);
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
    public function should_return_error_object_when_try_to_create_customer_without_required_fields()
    {
        $expected                   = array();
        $expected['name'][0]        = "The name field is required.";
        $expected['description'][0] = "The description field is required.";
        $expected['email'][0]       = "The email field is required.";

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
    public function should_return_error_object_when_try_to_create_customer_with_invalid_values()
    {
        $expected             = array();
        $expected['email'][0] = "The email must be a valid email address.";

        $request_params = [
            'name'        => 'Rebeka Champlin',
            'description' => 'Alias magni similique porro quo quisquam quia eaque.',
            'email'       => 'wehnerdotalbertatexampledotnet',
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
    public function should_return_error_object_when_try_to_create_customer_that_has_already_been_using_unique_values()
    {
        $expected             = array();
        $expected['name'][0]  = "The name has already been taken.";
        $expected['email'][0] = "The email has already been taken.";

        $factory = factory(App\Models\Customer::class)->create([
            'name'        => 'Rebeka Champlin',
            'description' => 'Alias magni similique porro quo quisquam quia eaque.',
            'email'       => 'hblock@example.org',
        ]);

        $request_params = [
            'name'        => 'Rebeka Champlin',
            'description' => 'Alias magni similique porro quo quisquam quia eaque.',
            'email'       => 'hblock@example.org',
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
    public function should_return_error_object_when_try_to_update_customer_without_required_fields()
    {
        $expected                   = array();
        $expected['name'][0]        = "The name field is required.";
        $expected['description'][0] = "The description field is required.";
        $expected['email'][0]       = "The email field is required.";

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
    public function should_return_zero_integer_when_try_to_delete_empty_customer()
    {
        $random_id = rand();

        $this->mock_repository->shouldReceive('delete')
                              ->with($random_id)
                              ->once()
                              ->andReturn(0);

        $actual = $this->mock_controller->destroy($random_id);

        $this->assertEquals(0, $actual);
    }

    /**
     * @test
     */
    public function should_return_error_object_when_try_to_add_features_to_customer_without_required_fields()
    {
        $expected                     = array();
        $expected['features_id'][0] = "The features id field is required.";

        $request_params = array();

        $request   = new AddFeaturesRequest();
        $rules     = $request->rules();
        $validator = Validator::make($request_params, $rules);

        $this->assertTrue($validator->fails());
        $this->assertEquals($expected, $validator->messages()->getMessages());
    }
}
