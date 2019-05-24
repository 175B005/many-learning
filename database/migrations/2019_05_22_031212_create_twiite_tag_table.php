<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwiiteTagTable extends Migration
{

    public function up()
    {
        Schema::create('tag_twiite', function (Blueprint $table) {
            $table->increments('id');
	    $table->integer('twiite_id');
	    $table->integer('tag_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tag_twiite');
    }
}
