<?php

use Mockery as Mockery;

use Api\Controllers\UserController;
use Api\Requests\User\CreateRequest;
use Api\Requests\User\GetRequest;
use Api\Requests\User\UpdateRequest;

class apiUserControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');

        $this->mock_repository = Mockery::mock('Api\Repositories\Contracts\UserRepositoryInterface');
        $this->mock_controller = new UserController($this->mock_repository);
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
    public function should_return_error_object_when_try_to_create_user_without_required_fields()
    {
        $expected                             = array();
        $expected['firstname'][0]             = "The firstname field is required.";
        $expected['lastname'][0]              = "The lastname field is required.";
        $expected['email'][0]                 = "The email field is required.";
        $expected['password'][0]              = "The password field is required.";
        $expected['password_confirmation'][0] = "The password confirmation field is required.";
        $expected['country'][0]               = "The country field is required.";

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
    public function should_return_error_object_when_try_to_create_user_with_invalid_values()
    {
        $expected                             = array();
        $expected['email'][0]                 = "The email must be a valid email address.";
        $expected['password_confirmation'][0] = "The password confirmation and password must match.";

        $request_params = [
            'firstname'             => 'Nicolette',
            'lastname'              => 'Robel',
            'email'                 => 'wehnerdotalbertatexampledotnet',
            'password'              => '12345678',
            'password_confirmation' => '87654321',
            'country'               => 'TH',
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
    public function should_return_error_object_when_try_to_create_user_that_has_already_been_using_unique_values()
    {
        $expected             = array();
        $expected['email'][0] = "The email has already been taken.";

        $factory = factory(App\Models\User::class)->create([
            'firstname' => 'Nicolette',
            'lastname'  => 'Robel',
            'email'     => 'Wehner.Albert@example.net',
            'country'   => 'TH',
        ]);

        $request_params = [
            'firstname'             => 'Nicolette',
            'lastname'              => 'Robel',
            'email'                 => 'Wehner.Albert@example.net',
            'password'              => '12345678',
            'password_confirmation' => '12345678',
            'country'               => 'TH',
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
    public function should_return_error_object_when_try_to_update_user_without_required_fields()
    {
        $expected                 = array();
        $expected['firstname'][0] = "The firstname field is required.";
        $expected['lastname'][0]  = "The lastname field is required.";
        $expected['email'][0]     = "The email field is required.";
        $expected['country'][0]   = "The country field is required.";

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
    public function should_return_zero_integer_when_try_to_delete_empty_user()
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
