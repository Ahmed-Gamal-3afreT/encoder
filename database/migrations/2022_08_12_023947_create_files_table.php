<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('file_id');
            $table->string('file_name');
            $table->boolean('file_status')->default(1);
            $table->text('file_key');
            

            $table->unsignedBigInteger('file_user_id');
            $table->foreign('file_user_id')->references('id')->on('users');

            $table->timestamps();
        });

 /*     $ivlen  = openssl_cipher_iv_length('AES-256-CBC');
        $IV = openssl_random_pseudo_bytes($ivlen);
        putenv ("CUSTOM_VARIABLE=$IV"); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
