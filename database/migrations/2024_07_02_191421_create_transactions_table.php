<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_details_id')->nullable();
            $table->integer('batch_id');
            $table->date('transaction_date');
            $table->integer('quantity');
            $table->integer('price_at_buy')->nullable();
            $table->enum('transaction_type', ['IN', 'OUT', 'PURCHASED']);
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
        Schema::dropIfExists('transactions');
    }
}
