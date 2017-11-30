<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetcoreContactItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netcore_contact__items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->string('default_value')->nullable();
            $table->boolean('is_translateable');
            $table->timestamps();
        });

        Schema::create('netcore_contact__item_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('item_id');
            $table->foreign('item_id', 'item_id')->references('id')->on('netcore_contact__items')->onDelete('cascade');

            $table->string('locale')->index();
            $table->string('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('netcore_contact__item_translations');
        Schema::dropIfExists('netcore_contact__items');
    }
}
