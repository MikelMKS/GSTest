<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_history', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_notification')->index('id_notification');
            $table->integer('id_user')->index('id_user');
            $table->integer('id_category')->index('id_category');
            $table->integer('id_type')->index('id_type');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications_history');
    }
};
