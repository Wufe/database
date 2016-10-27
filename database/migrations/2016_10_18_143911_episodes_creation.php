<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EpisodesCreation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( "episodes", function( Blueprint $table ){
            $table->increments( "id" );
            $table->string( "name" )->nullable();
            $table->string( "path" )->nullable();
            $table->string( "url")->nullable();
            $table->text( "headers" )->nullable();
            $table->string( "template" )->nullable();
            $table->string( "status" )->default( "ok" );
            $table->text( "metadata" )->nullable();
            $table->string( "issuer" )->nullable();
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
        Schema::drop( "episodes" );
    }
}
