@extends('layouts.template')
@section('content')
@include('components.notification')
<style>
    .form-wizard .sub label:not(.info){
        font-weight: 400;
    }

</style>
<form id="pengajuan_kredit" action="{{ route('pengajuan-kredit.store') }}" method="post">
    @csrf
    <div class="form-wizard active" data-index='0' data-done='true'>
        <div class="row">
            <div class="form-group col-md-12">
                <label for="">Nama Lengkap</label>
                <input type="text" name="name" id="nama" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" placeholder="Nama sesuai dengan KTP">
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
    @foreach ($dataAspek as $key => $value)
        @php
            $key += 1;
            $dataLevelSatu = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('level',2)->where('id_parent',$value->id)->get();
        @endphp
        @foreach ($dataLevelSatu as $item)
        @php
            $dataJawaban = \App\Models\OptionModel::select('id','id_item','option','skor')->where('id_item',$item->id)->get()
        @endphp

        @endforeach

        <div class="form-wizard" data-index='{{ $key }}' data-done='true'>
            @php
                echo "<pre>";
                print_r($dataLevelSatu);
                echo "</pre>";
            @endphp
        </div>
    @endforeach
    @foreach ($dataLevelSatu as $item)


    @endforeach
    <div class="row form-group">
        <div class="col text-right">
            <button class="btn btn-default btn-prev"><span class="fa fa-chevron-left"></span> Sebelumnya</button>
            <button class="btn btn-danger btn-next">Selanjutnya <span class="fa fa-chevron-right"></span></button>
            <button type="submit" class="btn btn-info btn-simpan" id="submit">Simpan <span class="fa fa-save"></span></button>
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
<script src="{{ asset('') }}js/custom.js"></script>
@endpush
