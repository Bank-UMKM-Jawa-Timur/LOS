@extends('layouts.template')
@section('content')
@include('components.notification')
<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }

</style>
<form id="pengajuan_kredit">
    <div class="form-wizard active" data-index='0' data-done='true'>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Nama sesuai dengan KTP">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">Kabupaten</label>
                <select name="kabupaten" class="form-control select2" id="kabupaten">
                    <option value="">---Pilih Kabupaten----</option>
                    @foreach ($dataKabupaten as $item)
                        <option value="{{ old('id',$item->id) }}">{{ $item->kabupaten }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="">Kecamatan</label>
                <select name="kec" id="kecamatan" class="form-control select2" >
                    <option value="">---Pilih Kecamatan----</option>

                    {{-- @foreach ($dataKecamatan as $item)
                    <option value="{{ old('id',$item->id) }}">{{ $item->kecamatan }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="">Desa</label>
                <select name="desa" id="desa" class="form-control select2" >
                    <option value="">---Pilih Desa----</option>

                    {{-- @foreach ($dataDesa as $item)
                    <option value="{{ old('id',$item->id) }}">{{ $item->desa }}</option>
                    @endforeach --}}
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="">Alamat Rumah</label>
                <textarea name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror" value="{{old('alamat_rumah')}}" id="" cols="30" rows="4" placeholder="Alamat Rumah disesuaikan dengan KTP"></textarea>
                @error('alamat_rumah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <hr>
            </div>
            <div class="form-group col-md-12">
                <label for="">Alamat Usaha</label>
                <textarea name="alamat_usaha" class="form-control @error('alamat_usaha') is-invalid @enderror" value="{{old('alamat_usaha')}}" id="" cols="30" rows="4" placeholder="Alamat Usaha disesuaikan dengan KTP"></textarea>
                @error('alamat_usaha')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">No. KTP</label>
                <input type="text" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" value="{{old('no_ktp')}}" id="" placeholder="Masukkan 16 digit No. KTP">
                @error('no_ktp')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">Tempat</label>
                <input type="text" name="tempat_lahir" id="" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{old('tempat_lahir')}}" placeholder="Tempat Lahir">
                @error('tempat_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" id="" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{old('tanggal_lahir')}}" placeholder="Tempat Lahir">
                @error('tanggal_lahir')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="">Status</label>
                <select name="status" id="" class="form-control @error('status') is-invalid @enderror select2" value="{{old('status')}}">
                    <option value="menikah">Menikah</option>
                    <option value="belum menikah">Belum Menikah</option>
                    <option value="duda">Duda</option>
                    <option value="janda">Janda</option>
                </select>
                @error('alamat_rumah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Sektor Kredit</label>
                <select name="sektor_kredit" id="" class="form-control @error('sektor_kredit') is-invalid @enderror select2" required value="{{old('sektor_kredit')}}">
                    <option value="perdagangan">Perdagangan</option>
                    <option value="perindustrian">Perindustrian</option>
                    <option value="dll">dll</option>
                </select>
                @error('sektor_kredit')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Jenis Usaha</label>
                <textarea name="jenis_usaha" class="form-control @error('jenis_usaha') is-invalid @enderror" value="{{old('jenis_usaha')}}" id="" cols="30" rows="4" placeholder="Jenis Usaha secara spesifik"></textarea>
                @error('jenis_usaha')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Jumlah Kredit yang diminta</label>
                <textarea name="jumlah_kredit" class="form-control @error('jumlah_kredit') is-invalid @enderror" value="{{old('jumlah_kredit')}}" id="" cols="30" rows="4" placeholder="Jumlah Kredit"></textarea>
                @error('jumlah_kredit')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Tujuan Kredit</label>
                <textarea name="tujuan_kredit" class="form-control @error('tujuan_kredit') is-invalid @enderror" value="{{old('tujuan_kredit')}}" id="" cols="30" rows="4" placeholder="Tujuan Kredit"></textarea>
                @error('tujuan_kredit')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Jaminan yang disediakan</label>
                <textarea name="jaminan" class="form-control @error('jaminan') is-invalid @enderror" value="{{old('jaminan')}}" id="" cols="30" rows="4" placeholder="Jaminan yang disediakan"></textarea>
                @error('jaminan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Hubungan Bank</label>
                <textarea name="hubungan_bank" class="form-control @error('hubungan_bank') is-invalid @enderror" value="{{old('hubungan_bank')}}" id="" cols="30" rows="4" placeholder="Hubungan dengan Bank"></textarea>
                @error('hubungan_bank')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Hasil Verifikasi</label>
                <textarea name="hasil_verifikasi" class="form-control @error('hasil_verifikasi') is-invalid @enderror" value="{{old('hasil_verifikasi')}}" id="" cols="30" rows="4" placeholder="Hasil Verifikasi Karakter Umum"></textarea>
                @error('hasil_verifikasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-wizard" data-index='1' data-done="false">
        <div class="row form-group">
            <div class="col-md-12">
                <label for="">Usaha dilakukan Sejak</label>
                <textarea name="keterangan_usaha" class="form-control" id="" cols="30" rows="4"></textarea>
                <small>Penjelasan singkat mengenai usaha</small>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                <label for="">Badan Usaha</label>
                <select name="" id="" class="form-control select2">
                    <option value="">---Pilih Select---</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="info" for="">Permodalan Dipenuhi Dari</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub">
            <div class="col-md-6">
                <label for="">Modal (awal) sendiri</label>
                <input type="text" class="form-control" placeholder="Masukkan nominal modal awal ">
            </div>
            <div class="col-md-6">
                <label for="">Modal Pinjaman</label>
                <input type="text" class="form-control" placeholder="Masukkan nominal modal pinjaman">
            </div>
        </div>
    </div>
    <div class="form-wizard" data-index='2' data-done="false">
        <div class="row">
            <div class="col">
                <label class="info" for="">a. Izin Usaha</label>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-6">
                <label for="">SIUP No.</label>
                <input type="text" class="form-control" placeholder="Input label 1">
            </div>
            <div class="col-md-6">
                <label for="">Jatuh Tempo pada</label>
                <input type="text" class="form-control" placeholder="Input label 1">
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-6">
                <label for="">TDP No.</label>
                <input type="text" class="form-control" placeholder="Input label 1">
            </div>
            <div class="col-md-6 sub">
                <label for="">Jatuh Tempo pada</label>
                <input type="text" class="form-control" placeholder="Input label 1">
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">NPWP No</label>
                <input type="text" name="" id="" class="form-control">
                <span>atau Surat Keterangan Usaha Ditanyakan lagi </span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="info" for="">b. Jaminan Tambahan
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="info" for="">Bukti Pemilikan</label>
                <small>(Isi salah satu dan diberikan keterangan)</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Untuk Tanah atau Bangunan</label>
            </div>
        </div>
        <div class="row form-group sub" >
            <div class="col-md-6">
                <label for="">SHM No</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Atas Nama </label>
                <input type="text" name="" id="" class="form-control">
            </div>
        </div>
        <div class="row form-group sub" >
            <div class="col-md-6">
                <label for="">SHGB No</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="">Atas Nama </label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="">Berakhirnya Hak </label>
                <input type="text" name="" id="" class="form-control">
            </div>

        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">Keterangan</label>
                <textarea name="keterangan_usaha" class="form-control" id="" cols="30" rows="4"></textarea>
                <small>Penjelasan singkat mengenai usaha</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label for="">Untuk Kendaraan Bermotor</label>
            </div>
        </div>
        <div class="row form-group sub" >
            <div class="col-md-6">
                <label for="">BPKB No</label>
                <input type="text" name="" id="" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="">Atas Nama </label>
                <input type="text" name="" id="" class="form-control">
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">Keterangan</label>
                <textarea name="keterangan_usaha" class="form-control" id="" cols="30" rows="4"></textarea>
                <small>Penjelasan singkat mengenai usaha</small>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="info" for="">c. Taksiran Harga
                </label>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-6">
                <label for="">THU Rp</label>
                <input type="text" name="" id="" class="form-control" placeholder="Contoh : Rp. 500000">
            </div>
            <div class="col-md-6">
                <label for="">THLS Rp  </label>
                <input type="text" name="" id="" class="form-control" placeholder="Contoh : Rp. 500000">
            </div>
        </div>
    </div>
    <div class="form-wizard " data-index='3' data-done="false">
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Lokasi Usaha</label>
            </div>
        </div>
        <div class="row form-group sub">
           <div class="col-md-12">
            <label for="">Alamat</label>
            <textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
            <small>Diisi alamat lengkap usaha</small>
           </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
             <label for="">Tata Ruang Tempat Usaha</label>
             <textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
             <small>Penjelasan singkat mengenai kondisi tempat usaha</small>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">Lingkungan</label>
                <select name="" id="" class="form-control select2">
                    <option value="">---Pilih Lingkungan ---</option>
                    <option value="">Perkampungan</option>
                    <option value="">Perkantoran</option>
                    <option value="">Perumahan</option>
                    <option value="">Industri</option>
                </select>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">Status Kepemilikan</label>
                <select name="" id="" class="form-control select2">
                    <option value="">---Pilih Status ---</option>
                    <option value="">Milik Sendiri</option>
                    <option value="">Milik Orang Lain</option>
                    <option value="">Sewa</option>
                </select>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-12">
                <label for="">Bukti Penguasaan Tempat Usaha</label>
                <select name="" id="" class="form-control select2">
                    <option value="">---Pilih Bukti ---</option>
                    <option value="">SHM</option>
                    <option value="">SHGB</option>
                    <option value="">SHGP</option>
                    <option value="">Sewa</option>
                </select>
                <small>Jika pilih sewa isi data dibawah ini :</small>
            </div>
        </div>
        <div class="row form-group sub">
            <div class="col-md-6">
                <label for="">Nomor</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-6">
                <label for="">Atas nama</label>
                <input type="text" name="" class="form-control" id="">
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Sarana Penunjang</label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Peralatan</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-5">
                <label for="">Nama Peralatan</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-5">
                <label for="">Kondisi</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-2">
                <a href="" class="btn btn-info my-4"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Transportasi</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-5">
                <label for="">Nama Transportasi</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-5">
                <label for="">Kondisi</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-2">
                <a href="" class="btn btn-info my-4"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Tenaga Kerja</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-12">
                <label for="">Jumlah Tenaga Kerja</label>
                <input type="text" name="" class="form-control" id="">
            </div>

        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-6 mt-3">
                <label for="">Tenaga Administrasi</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-6 mt-3">
                <label for="">Tenaga Produksi</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-6 mt-3">
                <label for="">Tenaga Pemasaran</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-6 mt-3">
                <label for="">DLL</label>
                <input type="text" name="" class="form-control" id="">
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Barang Dagangan</label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Ketersedian Barang</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-5">
                <label for="">Nama Peralatan</label>
                <input type="text" name="" class="form-control" id="">
            </div>
            <div class="col-md-5">
                <label for="">Kondisi</label>
                <select class="form-control select2" id="">
                    <option value="">Mudah</option>
                    <option value="">Sulit</option>
                </select>
            </div>
            <div class="col-md-2">
                <a href="" class="btn btn-info my-4"><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Daerah Pembelian Barang</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-12">
                <label for="">Penjelasan daerah pembelian</label>
                <textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Cara Pembayaran</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-12">
                <label for="">Pembayaran</label>
                <select name="" class="form-control select2" id="">
                    <option value="">Tunai</option>
                    <option value="">Kredit</option>
                    <option value="">Tempo</option>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                <label class="info" for="">Barang yang dijual</label>
            </div>
        </div>
        <div class="row form-group pl-3 sub ">
            <div class="col-md-12">
                <label for="">Jenis/macam barang</label>
                <input type="text" name="" class="form-control" id="">
            </div>

        </div>
    </div>
    <div class="form-wizard" data-index='4' data-done='false'>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Wialayah Pemasaran</label>
                <input type="text" name="wilayah" class="form-control @error('wilayah') is-invalid @enderror" value="{{old('wilayah')}}" placeholder="Masukkan Wilayah Kecamatan/Kota">
                @error('wilayah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Sistem Pemasaran</label>
                <input type="text" name="sistem_pemasaran" class="form-control @error('sistem_pemasaran') is-invalid @enderror" value="{{old('sistem_pemasaran')}}" placeholder="Masukkan Sistem Dagangan Dipasarkan">
                @error('sistem_pemasaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Omzet Penjualan</label>
                <input type="text" name="omzet_penjualan" class="form-control @error('omzet_penjualan') is-invalid @enderror" value="{{old('omzet_penjualan')}}" placeholder="Masukkan Omzet Penjualan">
                @error('omzet_penjualan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Cara Pembayaran</label>
                <textarea name="cara_pembayaran" class="form-control @error('cara_pembayaran') is-invalid @enderror" value="{{old('cara_pembayaran')}}" id="" cols="30" rows="4" placeholder="Cara Pembayaran"></textarea>
                @error('cara_pembayaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <hr>
            </div>
            <div class="form-group col-md-6">
                <label for="">Tingkat Pesaingan / Jml Pesaing</label>
                <input type="text" name="tingkat_pesaing" class="form-control @error('tingkat_pesaing') is-invalid @enderror" value="{{old('tingkat_pesaing')}}" placeholder="Masukkan Jml Pesaing">
                @error('tingkat_pesaing')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="">Rencana Peningkatan</label>
                <input type="text" name="rencana_peningkatan" class="form-control @error('rencana_peningkatan') is-invalid @enderror" value="{{old('rencana_peningkatan')}}" placeholder="Masukkan Jml Pesaing">
                @error('rencana_peningkatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group col-md-12">
                <label for="">Alasan Peningkatan</label>
                <textarea name="alasan_peningkatan" class="form-control @error('alasan_peningkatan') is-invalid @enderror" value="{{old('alasan_peningkatan')}}" id="" cols="30" rows="4" placeholder="Alasan Peningkatan"></textarea>
                @error('alasan_peningkatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <hr>
            </div>
        </div>
    </div>
    <div class="form-wizard" data-index='5' data-done='false'>

        <div class="row">
            <div class="col-lg-12">
                <label for="">Aktiva</label>
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Kas/Bank</label>
                <input type="number" name="kas" class="form-control" id="" placeholder="Masukkan Nominal Kas/Bank">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Piutang Dagang</label>
                <input type="number" name="piutang_dagang" class="form-control" id="" placeholder="Masukkan Nominal Piutang Dagang">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Persediaan Dagangan</label>
                <input type="number" name="persediaan_dagang" class="form-control" id="" placeholder="Masukkan Persediaan Dagang">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Tanah dan Bangunan</label>
                <input type="number" name="tanah_bangunan" class="form-control" id="" placeholder="Masukkan Tanah dan Bangunan">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Kendaraan</label>
                <input type="number" name="kendaraan" class="form-control" id="" placeholder="Masukkan Nominal Kendaraan">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Investaris</label>
                <input type="number" name="investaris" class="form-control" id="" placeholder="Masukkan Nominal Investaris">
            </div>
            <div class="col-lg-12">
                <label for="">Passiva</label>
            </div>

            <div class="form-group col-lg-6 sub">
                <label for="">Hutang Dagang</label>
                <input type="number" name="hutan_dagang" class="form-control" id="" placeholder="Masukkan Nominal Hutan Dagang">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Hutang Bank</label>
                <input type="number" name="hutang_bank" class="form-control" id="" placeholder="Masukkan Nominal Hutang Bank">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Hutang Jangka Panjang</label>
                <input type="number" name="hutan_jp" class="form-control" id="" placeholder="Masukkan Nominal Jangka Panjang">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Modal</label>
                <input type="number" name="modal" class="form-control" id="" placeholder="Masukkan Nominal Investaris">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Laba Ditahan</label>
                <input type="number" name="laba_ditahan" class="form-control" id="" placeholder="Masukkan Nominal Ditahan">
            </div>
            <div class="form-group col-lg-6 sub">
                <label for="">Laba Tahun Berjalan</label>
                <input type="number" name="laba_tb" class="form-control" id="" placeholder="Masukkan Nominal Laba Tahun Berjalan">
            </div>
        </div>
    </div>
    <div class="row form-group">
        <div class="col text-right">
            <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
            <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
            <button class="btn btn-info btn-simpan" id="submit">Simpan <span class="fa fa-save"></span></button>
            {{-- <button class="btn btn-info ">Simpan <span class="fa fa-chevron-right"></span></button> --}}
        </div>
    </div>
</form>



@endsection

@push('custom-script')
<script>
    $('#kabupaten').change(function(){
    var kabID = $(this).val();
    if(kabID){
        $.ajax({
           type:"GET",
           url:"/getkecamatan?kabID="+kabID,
           dataType: 'JSON',
           success:function(res){
            //    console.log(res);
            if(res){
                $("#kecamatan").empty();
                $("#desa").empty();
                $("#kecamatan").append('<option>---Pilih Kecamatan---</option>');
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#kecamatan").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#kecamatan").empty();
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#kecamatan").empty();
        $("#desa").empty();
    }
   });

   $('#kecamatan').change(function(){
    var kecID = $(this).val();
    // console.log(kecID);
    if(kecID){
        $.ajax({
           type:"GET",
           url:"/getdesa?kecID="+kecID,
           dataType: 'JSON',
           success:function(res){
            //    console.log(res);
            if(res){
                $("#desa").empty();
                $("#desa").append('<option>---Pilih Desa---</option>');
                $.each(res,function(nama,kode){
                    $("#desa").append('<option value="'+kode+'">'+nama+'</option>');
                });
            }else{
               $("#desa").empty();
            }
           }
        });
    }else{
        $("#desa").empty();
    }
   });
</script>
<script>

    function cekBtn(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()
        $(".btn-simpan").hide()

        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".btn-prev").show()
        }
        if (indexNow == 5) {

            $(".btn-next").hide()
            $(".btn-simpan").show()

            $('#pengajuan_kredit').on('submit',function(e){
                e.preventDefault();
                let name = $('#name').val();
                // $.ajax({
                //     url: "/pengajuan-kredit",
                //     type:"POST",
                //     data:{
                //         "_token": "{{ csrf_token() }}",
                //     },
                // })
                console.log(name);
                // console.log('berhasil');
            });

        }else{
            $(".btn-next").show()
            $(".btn-simpan").hide()

        }
    }
    function cekWizard(isNext=false){
        var indexNow = $(".form-wizard.active").data('index')
        // console.log(indexNow);
        if(isNext){
            $(".side-wizard li").removeClass('active')
        }

        $(".side-wizard li").removeClass('selected')

        for (let index = 0; index <= parseInt(indexNow); index++) {
            var selected = index==parseInt(indexNow) ? ' selected' : ''
            $(".side-wizard li[data-index='"+index+"']").addClass('active'+selected)
            $(".side-wizard li[data-index='"+index+"'] a span i").removeClass('fa-ban')
            $(".side-wizard li[data-index='"+index+"'] a span i").addClass('fa-check')
        }

    }
    cekBtn()
    cekWizard()

    $(".side-wizard li a").click(function(){
        var dataIndex = $(this).closest('li').data('index')
        if($(this).closest('li').hasClass('active')){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+dataIndex+"']").addClass('active')
            cekWizard()
        }
    })

    $(".btn-next").click(function(){
        var indexNow = $(".form-wizard.active").data('index')
        var next = parseInt(indexNow) + 1

        if($(".form-wizard[data-index='"+next+"']").length==1){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+next+"']").addClass('active')
            $(".form-wizard[data-index='"+indexNow+"']").attr('data-done','true')
        }

        cekWizard()
        cekBtn(true)
    })
    $(".btn-prev").click(function(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".form-wizard").removeClass('active')
            $(".form-wizard[data-index='"+prev+"']").addClass('active')
        }
        cekWizard()
        cekBtn()
    })


</script>
@endpush
