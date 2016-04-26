<?php

class apiCustomerModelTest extends TestCase
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
    public function should_return_instance_of_itself_when_create_customer_successful()
    {
        $params = [
            'name'        => str_random(10),
            'description' => str_random(50),
            'email'       => str_random(10) . '@example.com',
        ];
        $expected = factory(App\Models\Customer::class)->create($params);

        $this->seeInDatabase('customers', $params);
    }

    /**
     * @test
     */
    public function customer_and_feature_has_been_related_when_add_feature_to_customer()
    {
        $customer_expected = factory(App\Models\Customer::class)->create();
        $feature_expected  = factory(App\Models\Feature::class)->create();

        $customer_expected->push('features', array($feature_expected['_id']));

        $expected = [
            'features' => $feature_expected['_id'],
        ];

        $this->seeInDatabase('customers', $expected);
    }
}
