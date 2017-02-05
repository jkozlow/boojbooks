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
            $table->string('external_id', 100)->nullable();
            $table->integer('booklist_id')->default(0);
            $table->string('name', 1000)->nullable();;
            $table->string('author', 1000)->nullable();;
            $table->text('description')->nullable();;
            $table->text('notes')->nullable();;
            $table->integer('page_num')->default(0);
            $table->integer('page_count')->default(0);
            $table->string('infourl', 1000)->nullable();;
            $table->string('imageurl', 1000)->nullable();;
            $table->string('category', 1000)->nullable();;
            $table->double('time_to_read')->default(0);
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
        Schema::drop('books');
    }
}
