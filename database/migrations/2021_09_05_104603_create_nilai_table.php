<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->bigInteger('semester');
            $table->bigInteger('mahasiswa_id');
            $table->bigInteger('mata_kuliah_id');
            $table->integer('sks');
            $table->integer('bnilai')->comment('Big Nilai');
            $table->char('index_nilai', 2)->comment('A+ - E');
            $table->char('poin_nilai', 5)->comment('4 - 0');
            $table->float('total_nilai')->comment('sks x poin_nilai');
            $table->json('opt')->nullable();
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
        Schema::dropIfExists('nilai');
    }
}
