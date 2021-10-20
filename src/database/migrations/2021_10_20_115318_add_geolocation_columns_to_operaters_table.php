<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeolocationColumnsToOperatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operaters', function (Blueprint $table) {
            $table->json('geolocation_countries')->nullable()->after("decorators");
            $table->tinyInteger('geolocation_option')->nullable()->after("decorators");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operaters', function (Blueprint $table) {
            $table->dropColumn(['geolocation_option', 'geolocation_countries']);
        });
    }
}
