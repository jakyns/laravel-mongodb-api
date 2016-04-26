<?php

class apiFeatureModelTest extends TestCase
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
    public function should_return_instance_of_itself_when_create_feature_successful()
    {
        $params = [
            'name'         => str_random(10),
            'display_name' => str_random(10),
            'description'  => str_random(50),
        ];
        $expected = factory(App\Models\Feature::class)->create($params);

        $this->seeInDatabase('features', $params);
    }
}
