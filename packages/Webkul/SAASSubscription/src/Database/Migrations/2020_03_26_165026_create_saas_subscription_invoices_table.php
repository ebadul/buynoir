<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaasSubscriptionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_subscription_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('increment_id')->nullable();
            $table->string('status');
            $table->string('pending_reason');
            $table->decimal('grand_total', 12, 4)->default(0);
            $table->string('customer_email');
            $table->string('customer_name');
            $table->date('cycle_expired_on')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();

            $table->integer('saas_subscription_recurring_profile_id')->unsigned();
            $table->foreign('saas_subscription_recurring_profile_id', 'saas_subscription_invoices_recurring_profile_id_foreign')->references('id')->on('saas_subscription_recurring_profiles')->onDelete('cascade');

            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::table('saas_subscription_recurring_profiles', function (Blueprint $table) {
            $table->integer('saas_subscription_invoice_id')->nullable()->unsigned();
            $table->foreign('saas_subscription_invoice_id', 'saas_subscription_recurring_profiles_invoice_id_foreign')->references('id')->on('saas_subscription_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saas_subscription_invoices');
    }
}
