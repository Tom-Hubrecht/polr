<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLinkClicksToInteger extends Migration
{
    /**
     * Run the migrations.
     * Changes the "clicks" field in the link table to
     * an integer field rather than a string field.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table)
        {
            if (config('database')['default'] == 'pgsql') {
                $dropDefaultStatement = "ALTER TABLE links ALTER clicks DROP DEFAULT;";
                $alterColumnTypeStatement = "ALTER TABLE links ALTER clicks TYPE INT using clicks::integer;";
                $setDefaultStatement = "ALTER TABLE links ALTER clicks SET DEFAULT 0;";
                DB::statement($dropDefaultStatement);
                DB::statement($alterColumnTypeStatement);
                DB::statement($setDefaultStatement);
            } else {
                $table->integer('clicks')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table)
        {
            if (config('database')['default'] == 'pgsql') {
                $alterColumnTypeStatement = "ALTER TABLE links ALTER clicks TYPE character varying(255);";
                DB::statement($alterColumnTypeStatement);
            } else {
                $table->string('clicks')->change();
            }
        });
    }
}
