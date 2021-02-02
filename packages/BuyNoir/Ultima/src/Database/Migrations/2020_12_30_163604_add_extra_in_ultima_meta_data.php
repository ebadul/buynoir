<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraInUltimaMetaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ultima_meta_data', function (Blueprint $table) {
            $table->text('top_ribbon');
            $table->text('advertisement_four_content');
            $table->text('bottom_ribbon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ultima_meta_data', function (Blueprint $table) {
            //
        });
    }
}
