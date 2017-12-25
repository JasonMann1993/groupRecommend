<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->comment('用户负责人id');
            $table->string('name')->default('')->comment('商家名');
            $table->string('logo')->default('')->comment('logo');
            $table->string('desc')->default('')->comment('描述');
            $table->string('address')->default('')->comment('地址');
            $table->tinyInteger('talk')->default(1)->comment('洽谈状态；1未洽谈，2以洽谈');
            $table->tinyInteger('star')->default(1)->comment('商家星级1-5');
            $table->integer('order')->default(1)->comment('排序');
            $table->softDeletes();
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
        Schema::dropIfExists('businesses');
    }
}
