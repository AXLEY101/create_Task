<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name',128)->comment('タスク名');
            $table->date('period')->comment('タスクの期限');
            $table->text('detail')->comment('タスクの詳細');
            $table->unsignedTinyInteger('priority')->comment('重要度：(1:低い,2:普通:,3:高い)');
            $table->unsignedBigInteger('user_id')->comment('このタスクの所有者');
            $table->foreign('user_id')->references('id')->on('users');//外部キー制約
            //↑この記述でtasksテーブルのuser_idはusersテーブルに保存されているidしか登録できない
            //別記述法
            //$table->foreignId('user_id')->constrained(); Laravel 7以降ならこれでもOK
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
