<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alt');
            $table->date('date');
            $table->string('slug')->unique()->nullable();
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
        
        Schema::table('albums', function (Blueprint $table) {
            $table->foreign('default_image_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropForeign('albums_default_image_id_foreign');
        });
        
        Schema::dropIfExists('images');
    }
}
