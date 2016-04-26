<?php

use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersCollection extends Migration
{
    /**
     * The name of the database connection to use.
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->table('customers', function(Blueprint $collection) {
            $collection->index('name');
            $collection->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('customers');
    }
}
