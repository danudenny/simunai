<?php

use Illuminate\Database\Grammar;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

class CreateJembatanTable extends Migration
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
        DB::unprepared("CREATE TYPE kondisiJembatanEnum AS ENUM ('baik', 'sedang', 'rusak', 'rusak_sedang', 'rusak_berat');");
        DB::unprepared("CREATE TYPE statusJembatanEnum AS ENUM ('lokal', 'kabupaten', 'provinsi', 'nasional', 'lainnya');");
      
        DB::unprepared("CREATE TYPE kelasJembatanEnum AS ENUM ('I', 'II', 'IIIA', 'IIIB', 'IIIC');");

        Schema::create('jembatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jembatan', 100);
            $table->addColumn('raw', 'kondisi_jembatan', ['raw_type' => 'kondisiJembatanEnum'] )->nullable();
            $table->addColumn('raw', 'status_jembatan', ['raw_type' => 'statusJembatanEnum'] )->nullable();
            $table->float('panjang')->default(0);
            $table->float('lebar')->default(0);
            $table->addColumn('raw', 'jenis_perkerasan', ['raw_type' => 'jenisPerkerasanEnum'] )->nullable();
            $table->addColumn('raw', 'kelas_jembatan', ['raw_type' => 'kelasJembatanEnum'] )->nullable();
            $table->text('geojson');
            $table->string('style', 10);
            $table->unsignedBigInteger('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('cascade');
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
        DB::unprepared("DROP TYPE kondisiJembatanEnum");
        DB::unprepared("DROP TYPE statusJembatanEnum");
        DB::unprepared("DROP TYPE jenisPerkerasanEnum");
        DB::unprepared("DROP TYPE kelasJembatanEnum");
        Schema::dropIfExists('jembatan');
    }
}
