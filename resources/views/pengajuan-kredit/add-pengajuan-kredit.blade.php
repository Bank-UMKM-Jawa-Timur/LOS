@extends('layouts.template')
@section('content')
<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }

</style>
<div class="form-wizard " data-index='0' data-done='false'>
    <div class="row form-group">
        <div class="col-md-6">
            <label for="">Usaha Dilakukan Sejak</label>
            <input type="text" class="form-control" placeholder="Contoh: 2020">
        </div>
        <div class="col-md-6">
            <label for="">Badan Usaha</label>
            <select name="" id="" class="form-control select2">
                <option value="">---Pilih Badan Usaha ---</option>
                <option value="">Perseorangan</option>
                <option value="">Persero</option>
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
            <input type="text" class="form-control" placeholder="Input label 1">
        </div>
        <div class="col-md-6">
            <label for="">Modal Pinjaman</label>
            <input type="text" class="form-control" placeholder="Input label 1">
        </div>
    </div>
</div>
<div class="form-wizard " data-index='1' data-done="false">
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
<div class="form-wizard active" data-index='3' data-done="false">
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
<div class="row form-group">
    <div class="col text-right">
        <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
        <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
    </div>
</div>
@endsection

@push('custom-script')
<script>

    function cekBtn(){
        var indexNow = $(".form-wizard.active").data('index')
        var prev = parseInt(indexNow) - 1
        var next = parseInt(indexNow) + 1

        $(".btn-prev").hide()

        if($(".form-wizard[data-index='"+prev+"']").length==1){
            $(".btn-prev").show()
        }
    }
    function cekWizard(isNext=false){
        var indexNow = $(".form-wizard.active").data('index')
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
