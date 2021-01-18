<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaasSubscriptionRecurringProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_subscription_recurring_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_id')->nullable();
            $table->string('state');
            $table->string('type');
            $table->string('payment_status');
            $table->string('schedule_description');
            $table->string('period_unit');
            $table->string('tin')->nullable();
            $table->decimal('amount', 12, 4)->default(0);
            $table->string('payment_method')->nullable();
            $table->date('cycle_expired_on')->nullable();
            $table->date('next_due_date')->nullable();

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
        Schema::dropIfExists('saas_subscription_recurring_profiles');
    }
}
