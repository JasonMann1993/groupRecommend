<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('微信昵称');
            $table->string('avatar')->default('')->comment('头像');
            $table->tinyInteger('type')->default(1)->comment('1普通2商家');
            $table->string('group')->default('')->comment('所在群聊；群聊之间用逗号隔开');
            $table->string('address')->default('')->comment('用户地址');
            $table->tinyInteger('active')->default(1)->comment('活跃度1-5');
            $table->boolean('block')->default(0)->comment('是否拉黑；1拉黑');
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
        Schema::dropIfExists('members');
    }
}
