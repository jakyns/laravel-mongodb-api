<?php

use Illuminate\Database\Seeder;

class CustomersCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::collection('customers')->delete();

        factory(App\Models\Customer::class, 5)->create();
    }
}
