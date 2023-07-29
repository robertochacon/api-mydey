<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_entity')->nullable();
            $table->foreign('id_entity')->references('id')->on('entities');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('ws')->nullable();
            $table->string('email')->nullable();
            $table->string('identification')->nullable();
            $table->string('date')->nullable();
            $table->string('service')->nullable();
            $table->string('note')->nullable();
            $table->enum('status',['process','active','inactive'])->default('process');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}
