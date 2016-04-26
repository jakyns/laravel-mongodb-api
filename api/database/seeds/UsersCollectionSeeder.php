<?php

use Illuminate\Database\Seeder;

class UsersCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        DB::collection('users')->delete();

        factory(App\Models\User::class, 10)->create();
    }
}
