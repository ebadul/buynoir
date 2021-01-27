<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaasSubscriptionBillingAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_subscription_billing_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('address');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->integer('postcode');
            $table->string('phone');

            $table->integer('saas_subscription_recurring_profile_id')->nullable()->unsigned();
            $table->foreign('saas_subscription_recurring_profile_id', 'saas_subscription_billing_addresses_recurring_profile_id_foreign')->references('id')->on('saas_subscription_recurring_profiles')->onDelete('cascade');

            $table->integer('saas_subscription_invoice_id')->nullable()->unsigned();
            $table->foreign('saas_subscription_invoice_id', 'saas_subscription_billing_addresses_invoice_id_foreign')->references('id')->on('saas_subscription_invoices')->onDelete('cascade');

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

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
        Schema::dropIfExists('saas_subscription_billing_addresses');
    }
}
