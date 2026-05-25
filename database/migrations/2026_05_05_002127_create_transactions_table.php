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
            $table->id(); // ✅ WAJIB BANGET

            $table->foreignId('user_id')->constrained();
            $table->foreignId('address_id')->constrained();

            $table->integer('total_price');
            $table->string('status')->default('pending');
            $table->string('payment_method')->nullable();
            $table->foreignId('courier_id')->nullable()->constrained('users');
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
