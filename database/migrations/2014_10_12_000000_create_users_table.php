<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->char('role', 1)->comment('0:superadmin, 1:dosen, 2:mahasiswa, 3:operator');
            $table->bigInteger('prodi_id')->nullable();
            $table->char('jenis_kelamin', 1)->comment('L: Laki-laki, P: Perempuan')->default('L')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
