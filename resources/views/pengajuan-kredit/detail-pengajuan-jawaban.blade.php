@extends('layouts.template')
@section('content')
@include('components.notification')

<style>
    .sub label:not(.info){
        font-weight: 400;
    }
    h4{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 20px;
        /* border-bottom: 1px solid #dc3545; */
    }
    h5{
        color: #1f1d62;
        font-weight: 600 !important;
        font-size: 18px;
        /* border-bottom: 1px solid #dc3545; */
    }
    .form-wizard h6{
        color: #c2c7cf;
        font-weight: 600 !important;
        font-size: 16px;
        /* border-bottom: 1px solid #dc3545; */
    }
</style>
<div class="">
    <form action="{{ route('pengajuan.insertkomentar') }}" method="POST" >
    @csrf
        <div class="row">
            @forelse ($jawabanpengajuan as $item)
            <input type="hidden" name="id_pengajuan" value="{{ old('id_pengajuan',$item->id_pengajuan) }}">
                @if ($item->level == 4)
                    @php
                        $item_data = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item->id_parent)->get();
                    @endphp
                    @foreach ($item_data as $valueLevelEmpat)
                        @php
                            $item_data_empat_tiga = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$valueLevelEmpat->id_parent)->get();
                        @endphp
                        @foreach ($item_data_empat_tiga as $item_empat_tiga)
                            @php
                                $item_data_empat_satu = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item_empat_tiga->id_parent)->first();
                            @endphp
                            <div class="form-group col-md-12">
                                <label for="">{{ $item->nama }}</label>
                                <div class="row sub">
                                    <div class="col-md-6">
                                        <label for="">Jawaban</label>
                                        <input type="text" name="name[]" id="nama" class="form-control"  value="{{old('name',$item->name_option)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Skor</label>
                                        <input type="text" name="skor[]" id="nama" class="form-control"  value="{{old('skor',$item->skor)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 sub">
                                <label for="">Komentar</label>
                                <textarea name="komentar[]" class="form-control" id="" cols="1" rows="1"></textarea>
                            </div>
                            <div class="form-group col-md-6 sub">
                                <label for="">Skor</label>
                                <input type="number" name="skor_penyelia[]" id="" class="form-control" value="{{ old('skor_by_sistem',$item->skor) }}">
                            </div>
                            <div class="form-group col-md-12">
                                <input type="hidden" name="id_item[]" value="{{ old('id', $item_data_empat_satu->id) }}" id="">
                            </div>
                        @endforeach
                    @endforeach
                @endif
                @if ($item->level == 3)
                    @php
                        $item_data_dua = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item->id_parent)->get();
                    @endphp

                    @foreach ($item_data_dua as $item_data_dua_dua)
                        @php
                            $item_data_dua_satu = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item_data_dua_dua->id_parent)->get();
                        @endphp
                        @foreach ($item_data_dua_satu as $item_dua_satu)
                            <div class="form-group col-md-12">
                                <label for="">{{ $item->nama }}</label>
                                <div class="row sub">
                                    <div class="col-md-6">
                                        <label for="">Jawaban</label>
                                        <input type="text" name="name[]" id="nama" class="form-control"  value="{{old('name',$item->name_option)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Skor</label>
                                        <input type="text" name="skor[]" id="nama" class="form-control"  value="{{old('skor',$item->skor)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 sub">
                                <label for="">Komentar</label>
                                <textarea name="komentar[]" class="form-control" id="" cols="1" rows="1"></textarea>
                            </div>
                            <div class="form-group col-md-6 sub">
                                <label for="">Skor</label>
                                <input type="number" name="skor_penyelia[]" id="" class="form-control" value="{{ old('skor_by_sistem',$item->skor) }}">
                            </div>

                            <div class="form-group col-md-12">
                                <input type="hidden" name="id_item[]" value="{{ old('id', $item_dua_satu->id) }}" id="">
                            </div>
                        @endforeach
                    @endforeach
                @endif
                @if ($item->level == 2)
                    @php
                        $item_data_satu = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item->id_parent)->get();
                    @endphp
                    @foreach ($item_data_satu as $item_satu)
                        <div class="form-group col-md-12">
                            <label for="">{{ $item->nama }}</label>
                            <div class="row sub">
                                <div class="col-md-6">
                                    <label for="">Jawaban</label>
                                    <input type="text" name="name[]" id="nama" class="form-control"  value="{{old('name',$item->name_option)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Skor</label>
                                    <input type="text" name="skor[]" id="nama" class="form-control"  value="{{old('skor',$item->skor)}}" placeholder="Nama sesuai dengan KTP" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 sub">
                            <label for="">Komentar</label>
                            <textarea name="komentar[]" class="form-control" id="" cols="1" rows="1"></textarea>
                        </div>
                        <div class="form-group col-md-6 sub">
                            <label for="">Skor</label>
                            <input type="number" name="skor_penyelia[]" id="" class="form-control" value="{{ old('skor_by_sistem',$item->skor) }}">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" name="id_item[]" value="{{ old('id', $item_satu->id) }}" id="">
                        </div>
                    @endforeach
                @endif
                {{-- @php
                    $id_option = $item->id_option;
                    $item_data = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id_parent',$id_option)->get();
                @endphp
                @foreach ($item_data as $item)
                    @if ($item->level == 4)
                        @php
                            $id_option = $item->id_option;
                            $item_data_level = \App\Models\ItemModel::select('id','nama','level','id_parent')->where('id',$item->id)->get();
                        @endphp
                    @endif
                @php
                    echo "<pre>";
                    print_r($item_data);
                    echo "</pre>";
                @endphp
                @endforeach --}}

                {{-- {{ $item_data }} --}}
            @empty
                <p class="text-center">Tidak ada data yang tersimpan.</p>
            @endforelse
        </div>
        <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
        <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
    </form>
</div>


@endsection
