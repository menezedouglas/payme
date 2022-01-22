<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payer_account_id');
            $table->unsignedBigInteger('payee_account_id');
            $table->unsignedBigInteger('amount');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payer_account_id')->references('id')->on('financial_accounts');
            $table->foreign('payee_account_id')->references('id')->on('financial_accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_transactions');
    }
}
