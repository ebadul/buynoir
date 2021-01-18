<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaasSubscriptionPurchasedPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_subscription_purchased_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->text('description');
            $table->decimal('monthly_amount', 12, 4)->default(0);
            $table->decimal('yearly_amount', 12, 4)->default(0);
            $table->integer('allowed_products')->default(0);
            $table->integer('allowed_categories')->default(0);
            $table->integer('allowed_attributes')->default(0);
            $table->integer('allowed_attribute_families')->default(0);
            $table->integer('allowed_channels')->default(0);
            $table->integer('allowed_orders')->default(0);

            $table->integer('saas_subscription_recurring_profile_id')->unsigned();
            $table->foreign('saas_subscription_recurring_profile_id', 'saas_subscription_purchased_plans_recurring_profile_id_foreign')->references('id')->on('saas_subscription_recurring_profiles')->onDelete('cascade');

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::table('saas_subscription_recurring_profiles', function (Blueprint $table) {
            $table->integer('saas_subscription_purchased_plan_id')->nullable()->unsigned();
            $table->foreign('saas_subscription_purchased_plan_id', 'saas_subscription_recurring_profiles_purchased_plan_id_foreign')->references('id')->on('saas_subscription_purchased_plans')->onDelete('cascade');
        });

        Schema::table('saas_subscription_invoices', function (Blueprint $table) {
            $table->integer('saas_subscription_purchased_plan_id')->nullable()->unsigned();
            $table->foreign('saas_subscription_purchased_plan_id', 'saas_subscription_invoices_purchased_plan_id_foreign')->references('id')->on('saas_subscription_purchased_plans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saas_subscription_purchased_plans');
    }
}
