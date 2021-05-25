<?php

use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class CreateRiwayatTable extends Migration
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
        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('kegiatan');
            $table->double('nilai');
            $table->string('sumber_dana');
            $table->unsignedBigInteger('jalan_id');
            $table->foreign('jalan_id')->references('id')->on('jalan')->onDelete('cascade');
            $table->unsignedBigInteger('kontraktor_id');
            $table->foreign('kontraktor_id')->references('id')->on('kontraktor')->onDelete('cascade');
            $table->addColumn('raw', 'status', ['raw_type' => 'statusRiwayat'] )->nullable(true);
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
        Schema::dropIfExists('riwayat');
    }
}
