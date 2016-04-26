<?php

use Illuminate\Database\Seeder;

class FeaturesCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::collection('features')->delete();

        factory(App\Models\Feature::class, 5)->create();
    }
}
