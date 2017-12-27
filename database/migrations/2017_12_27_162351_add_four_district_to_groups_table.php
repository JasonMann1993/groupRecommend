<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFourDistrictToGroupsTable extends Migration
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
            $table->string('district_a')->default('')->comment('小区a');
            $table->string('district_b')->default('')->comment('小区b');
            $table->string('district_c')->default('')->comment('小区c');
            $table->string('district_d')->default('')->comment('其他');
            $table->decimal('ratio_a')->default(0)->comment('a小区所占比列');
            $table->decimal('ratio_b')->default(0)->comment('b小区所占比列');
            $table->decimal('ratio_c')->default(0)->comment('c小区所占比列');
            $table->decimal('ratio_d')->default(0)->comment('其他所占比列');
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
            $table->dropColumn('district_a');
            $table->dropColumn('district_b');
            $table->dropColumn('district_c');
            $table->dropColumn('district_d');
            $table->dropColumn('ratio_a');
            $table->dropColumn('ratio_b');
            $table->dropColumn('ratio_c');
            $table->dropColumn('ratio_d');
        });
    }
}
