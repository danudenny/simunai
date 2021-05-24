<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLampiranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lampiran', function($table) {
            $table->string('url')->nullable(true);
            $table->boolean('is_video')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lampiran', function($table) {
            $table->dropColumn('url');
            $table->dropColumn('is_video');
        });
    }
}
