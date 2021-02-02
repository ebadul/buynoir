<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUltimaMetaData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultima_meta_data', function (Blueprint $table) {
            $table->increments('id');
            $table->text('home_page_content');
            $table->text('footer_left_content');
            $table->text('footer_middle_content');
            $table->boolean('slider')->default(0);
            $table->json('advertisement')->nullable();
            $table->integer('sidebar_category_count')->default(9);
            $table->integer('featured_product_count')->default(10);
            $table->integer('new_products_count')->default(10);
            $table->text('subscription_bar_content')->nullable();
            $table->json('product_view_images')->nullable();
            $table->text('header_content_count');
            $table->text('product_policy')->nullable();
            $table->text('locale');
            $table->text('channel');
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
        Schema::dropIfExists('new_theme_meta_data');
    }
}
