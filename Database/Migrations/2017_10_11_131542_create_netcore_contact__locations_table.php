<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetcoreContactLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netcore_contact__locations', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_active');
            $table->timestamps();
        });

        Schema::create('netcore_contact__location_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('location_id');
            $table->foreign('location_id', 'location_id')->references('id')->on('netcore_contact__locations')->onDelete('cascade');

            $table->string('address_full');
            $table->string('address_short');
            $table->string('country');
            $table->string('city');
            $table->string('zip_code');
            $table->string('lat');
            $table->string('lng');

            $table->string('locale')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('netcore_contact__location_translations');
        Schema::dropIfExists('netcore_contact__locations');
    }
}
