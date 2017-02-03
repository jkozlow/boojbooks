<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Books extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('external_id', 100);
            $table->integer('booklist_id');
            $table->string('name', 1000);
            $table->string('author');
            $table->text('description');
            $table->text('notes');
            $table->string('pagenum', 100);
            $table->string('page_count', 100);
            $table->string('infourl', 1000);
            $table->string('imageurl', 1000);
            $table->string('category', 1000);
            $table->datetime('updated_at');
            $table->datetime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
