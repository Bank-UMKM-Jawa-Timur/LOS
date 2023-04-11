@extends('layouts.template')
@section('content')

@include('components.notification')
<div class="row justify-content-between">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-2 mb-3">
                <a href="{{ $btnLink }}" class="btn btn-primary px-3"><i class="fa fa-plus-circle"></i>
                    {{ $btnText }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
    </div>
</div>
<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Tanggal Input</th>
                <th>Nama Nasabah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data_pengajuan as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>
                        <div class="d-flex">
                            <div class="btn-group">
                                <button type="button" data-toggle="dropdown" class="btn btn-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16" style="color: black">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>
                                </button>
                                <div class="dropdown-menu">
                                {{-- @if ($item->posisi == 'Proses Input Data')
                                    <a href="{{ route('pengajuan-kredit.edit',$item->id_pengajuan) }}" class="dropdown-item">
                                        Edit data
                                    </a>
                                    <a href="{{ route('pengajuan.check.penyeliakredit',$item->id_pengajuan) }}" class="dropdown-item">Tindak lanjut Review Penyelia</a>
                                    <a target="_blank" href="{{ route('cetak',$item->id_pengajuan) }}" class="dropdown-item">Cetak</a>
                                @else
                                    <a target="_blank" href="{{ route('cetak',$item->id_pengajuan) }}" class="dropdown-item">Cetak</a>
                                @endif --}}
                                </div>
                            </div>
                        </div>
                    </td>
                @empty
                    <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
                </tr>
                @endforelse
        </tbody>
    </table>
    <div>
        {{$data_pengajuan->links()}}
        Menampilkan 
        {{$data_pengajuan->firstItem()}}
         - 
        {{$data_pengajuan->lastItem()}}
         dari 
        {{$data_pengajuan->total()}} Data
    </div>
    <div class="pull-right">
    </div>
</div>
@endsection
