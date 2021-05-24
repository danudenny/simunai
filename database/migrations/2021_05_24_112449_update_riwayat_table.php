<?php


use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class UpdateRiwayatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Grammar::macro('typeRaw', function (Fluent $column) {
            return $column->get('raw_type');
        });
        DB::unprepared("CREATE TYPE statusRiwayat AS ENUM ('On Progress', 'Selesai');");
        Schema::table('riwayat', function($table) {
            $table->addColumn('raw', 'status', ['raw_type' => 'statusRiwayat'] )->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('riwayat', function($table) {
            $table->dropColumn('status');
        });
    }
}
