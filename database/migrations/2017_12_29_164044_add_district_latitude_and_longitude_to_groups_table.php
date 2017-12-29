<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDistrictLatitudeAndLongitudeToGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
            $table->double('latitude_a', 10, 6)->nullable()->comment('纬度');
            $table->double('longitude_a', 10, 6)->nullable()->comment('经度');
            $table->double('latitude_b', 10, 6)->nullable()->comment('纬度');
            $table->double('longitude_b', 10, 6)->nullable()->comment('经度');
            $table->double('latitude_c', 10, 6)->nullable()->comment('纬度');
            $table->double('longitude_c', 10, 6)->nullable()->comment('经度');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            //
            $table->dropColumn('latitude_a');
            $table->dropColumn('latitude_b');
            $table->dropColumn('latitude_c');
            $table->dropColumn('longitude_a');
            $table->dropColumn('longitude_b');
            $table->dropColumn('longitude_c');
        });
    }
}
