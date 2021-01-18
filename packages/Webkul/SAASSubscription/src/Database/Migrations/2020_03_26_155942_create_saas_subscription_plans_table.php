<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaasSubscriptionPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_subscription_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description');
            $table->decimal('monthly_amount', 12, 4)->default(0);
            $table->decimal('yearly_amount', 12, 4)->default(0);
            $table->integer('allowed_products')->default(0);
            $table->integer('allowed_categories')->default(0);
            $table->integer('allowed_attributes')->default(0);
            $table->integer('allowed_attribute_families')->default(0);
            $table->integer('allowed_channels')->default(0);
            $table->integer('allowed_orders')->default(0);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('saas_subscription_plans');
    }
}
