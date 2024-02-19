<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanDagulirTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_dagulir_temp', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('nama_pj_ketua', 100)->nullable()->nullable();
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('telp', 15)->nullable();
            $table->enum('jenis_usaha', [1,2,3,4,5,6,7,8,9,10])->nullable();
            $table->string('ket_agunan')->nullable();
            $table->mediumText('hubungan_bank')->nullable();
            $table->double('nominal', 12, 0, true)->nullable();
            $table->string('tujuan_penggunaan')->nullable();
            $table->tinyInteger('jangka_waktu', false, true)->nullable();
            $table->string('kode_bank_pusat')->nullable();
            $table->bigInteger('kode_bank_cabang', false, true)->nullable();
            $table->unsignedBigInteger('kec_ktp')->nullable();
            $table->unsignedBigInteger('kotakab_ktp')->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->unsignedBigInteger('kec_dom')->nullable();
            $table->unsignedBigInteger('kotakab_dom')->nullable();
            $table->string('alamat_dom')->nullable();
            $table->unsignedBigInteger('kec_usaha')->nullable();
            $table->unsignedBigInteger('kotakab_usaha')->nullable();
            $table->string('alamat_usaha')->nullable();
            $table->tinyInteger('tipe', false, true)->nullable();
            $table->string('npwp', 15)->nullable();
            $table->tinyInteger('jenis_badan_hukum', false, true)->nullable();
            $table->string('tempat_berdiri')->nullable();
            $table->date('tanggal_berdiri')->nullable();
            $table->date('tanggal')->comment('Tanggal pengajuan')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('pengajuan_dagulir_temp');
    }
}
