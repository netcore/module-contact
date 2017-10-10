<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetcoreContactInfoBlocksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netcore_contact__info_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order');
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });

        Schema::create('netcore_contact__info_block_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('info_block_id');
            $table->string('title');
            $table->text('content');

            $table->foreign('info_block_id')->references('id')->on('netcore_contact__info_blocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('netcore_contact__info_block_translations');
        Schema::dropIfExists('netcore_contact__info_blocks');
    }
}
