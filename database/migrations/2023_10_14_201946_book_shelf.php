<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('book_shelves', function (Blueprint $table) {
            $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books');

            $table->unsignedBigInteger('shelf_id');
            $table->foreign('shelf_id')->references('id')->on('shelves');

            $table->integer('row');

            $table->primary(['book_id', 'shelf_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_shelves');
    }
};
