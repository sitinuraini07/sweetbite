<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailedAddressFieldsToAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('kota')->nullable()->after('phone_number');
            $table->string('province')->nullable()->after('kota');
            $table->string('regency')->nullable()->after('province');
            $table->string('district')->nullable()->after('regency');
            $table->string('village')->nullable()->after('district');
        });
    }

    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropColumn(['province', 'regency', 'district', 'village']);
        });
    }
}
