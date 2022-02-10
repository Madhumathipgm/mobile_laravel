<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMobileRefDataItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_ref_items', function (Blueprint $table) {
            $table->id()->autoIncrement()->nullable(false);
            $table->integer('id_parent');
            $table->tinyInteger('type')->nullable(false);
            $table->string('key')->nullable(false);
            $table->string('TextDe')->nullable(false);
            $table->string('TextEn')->nullable(false);
            $table->string('TextFr')->nullable(false);
            $table->text('date')->nullable()->default(null)->change();
            $table->unique(['id_parent','type','key']);

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_ref_items');
    }
}
