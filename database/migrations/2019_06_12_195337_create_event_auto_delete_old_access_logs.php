<?php

use Illuminate\Database\Migrations\Migration;

class CreateEventAutoDeleteOldAccessLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::unprepared("
            DROP EVENT IF EXISTS AutoDeleteOldAccessLogsInWheelers;
            CREATE EVENT AutoDeleteOldAccessLogsInWheelers
            ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 DAY
            ON COMPLETION PRESERVE
            DO
            DELETE LOW_PRIORITY FROM access_logs WHERE `created_at` < DATE_SUB(NOW(), INTERVAL 20 DAY)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::unprepared("
            DROP EVENT IF EXISTS AutoDeleteOldAccessLogsInWheelers;
        ");
    }
}
