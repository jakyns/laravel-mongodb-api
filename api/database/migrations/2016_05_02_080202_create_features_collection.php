<?php

use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesCollection extends Migration
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
        Schema::connection($this->connection)->table('features', function(Blueprint $collection) {
            $collection->index('name');
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::drop('features');
    }
}
