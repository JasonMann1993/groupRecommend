<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatitudeAndLongitudeToMembersAndBusinesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            //
            $table->double('latitude',10,6)->nullable()->comment('纬度');
            $table->double('longitude',10,6)->nullable()->comment('经度');
        });

        Schema::table('businesses', function (Blueprint $table) {
            //
            $table->double('latitude',10,6)->nullable()->comment('纬度');
            $table->double('longitude',10,6)->nullable()->comment('经度');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            //
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });

        Schema::table('businesses', function (Blueprint $table) {
            //
            $table->dropColumn('latitude');
            $table->dropColumn('longitude');
        });
    }
}
