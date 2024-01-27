<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanDagulirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_dagulir', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pendaftaran', 17)->unique();
            $table->string('nama', 100);
            $table->string('nama_pj_ketua', 100)->nullable();
            $table->string('nik', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('telp', 15);
            $table->enum('jenis_usaha', [1,2,3,4,5,6,7,8,9,10]);
            $table->double('nominal', 12, 0, true);
            $table->string('tujuan_penggunaan');
            $table->tinyInteger('jangka_waktu', false, true)
                ->comment('Jangka waktu dalam bulan');
            $table->string('kode_bank_pusat');
            $table->bigInteger('kode_bank_cabang', false, true);
            $table->foreignId('kec_ktp')->constrained('kecamatan');
            $table->foreignId('kotakab_ktp')->constrained('kabupaten');
            $table->string('alamat_ktp');
            $table->foreignId('kec_dom')->constrained('kecamatan');
            $table->foreignId('kotakab_dom')->constrained('kabupaten');
            $table->string('alamat_dom');
            $table->foreignId('kec_usaha')->constrained('kecamatan');
            $table->foreignId('kotakab_usaha')->constrained('kabupaten');
            $table->string('alamat_usaha');
            $table->tinyInteger('tipe', false, true)
                ->comment('Tipe pengajuan');
            $table->string('npwp', 15);
            $table->tinyInteger('jenis_badan_hukum', false, true);
            $table->string('tempat_berdiri');
            $table->date('tanggal_berdiri');
            $table->date('tanggal')->comment('Tanggal pengajuan');
            $table->foreignId('user_id')->constrained('users');
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
        Schema::dropIfExists('pengajuan_dagulir');
    }
}
