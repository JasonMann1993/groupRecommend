<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberPlotGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_plot_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->comment('群表id');
            $table->string('flag', 1)->comment('小区字母标识（例如：a）');
            $table->integer('member_id')->comment('members表id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_plot_groups');
    }
}
