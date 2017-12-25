<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('群名');
            $table->string('logo')->default('')->comment('logo');
            $table->string('desc')->default('')->comment('群聊描述');
            $table->string('address')->default('')->comment('地址');
            $table->double('latitude',10,6)->nullable()->comment('纬度');
            $table->double('longitude',10,6)->nullable()->comment('经度');
            $table->string('wx')->default('')->comment('群主微信');
            $table->string('qr_code')->default('')->comment('二维码');
            $table->integer('order')->default(0)->comment('排序');
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
        Schema::dropIfExists('groups');
    }
}
