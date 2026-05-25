<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerImageToDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('name');
        });
    }

    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('banner_image');
        });
    }
}
