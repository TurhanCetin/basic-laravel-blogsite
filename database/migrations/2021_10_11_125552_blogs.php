<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Blogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('categoryid')->nullable();
            $table->string('title');
            $table->string('subtitle');
            $table->string('image');
            $table->longText('description');
            $table->string('slug');
            $table->integer('see')->default(0);
            $table->timestamps();

            $table->foreign('categoryid')
                ->references('id')
                ->on('categories');
                //->onDelete('cascade'); eğerki bir kategori silindiğinde içerisindeki bloglarında silinmesini istiyorsak bunu kullanabiliriz.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
