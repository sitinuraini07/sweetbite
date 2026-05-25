<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('proof_image')->nullable()->after('courier_id');
            $table->timestamp('customer_confirmed_at')->nullable()->after('proof_image');
            $table->string('refund_reason')->nullable()->after('customer_confirmed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['proof_image', 'customer_confirmed_at', 'refund_reason']);
        });
    }
};
