<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EpisodesToCollectionsLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( "episodes", function( Blueprint $table ){
            $table->integer( "collection_id" )->unsigned()->nullable()->after( "issuer" );
            $table->foreign( "collection_id" )->references( "id" )->on( "collections" );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( "episodes", function( Blueprint $table ){
            $table->dropForeign( "episodes_collection_id_foreign" );
            $table->dropColumn( "collection_id" );
        });
    }
}
