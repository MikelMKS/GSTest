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
        Schema::table('notifications_history', function (Blueprint $table) {
            $table->foreign(['id_type'], 'notifications_history_ibfk_4')->references(['id'])->on('notifications_types');
            $table->foreign(['id_notification'], 'notifications_history_ibfk_1')->references(['id'])->on('notifications');
            $table->foreign(['id_category'], 'notifications_history_ibfk_3')->references(['id'])->on('categories');
            $table->foreign(['id_user'], 'notifications_history_ibfk_2')->references(['id'])->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications_history', function (Blueprint $table) {
            $table->dropForeign('notifications_history_ibfk_4');
            $table->dropForeign('notifications_history_ibfk_1');
            $table->dropForeign('notifications_history_ibfk_3');
            $table->dropForeign('notifications_history_ibfk_2');
        });
    }
};
