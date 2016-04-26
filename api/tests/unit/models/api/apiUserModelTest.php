<?php

class apiUserModelTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    public function tearDown()
    {
        Artisan::call('migrate:reset');
    }

    /**
     * @test
     */
    public function should_return_instance_of_itself_when_create_user_successful()
    {
        $params = [
            'firstname' => 'Laravel',
            'lastname'  => 'MongoDB',
            'email'     => str_random(10) . '@api.com',
            'password'  => bcrypt(str_random(10)),
            'country'   => str_random(10),
        ];
        $expected = factory(App\Models\User::class)->create($params);

        $this->seeInDatabase('users', $params);
    }
}
