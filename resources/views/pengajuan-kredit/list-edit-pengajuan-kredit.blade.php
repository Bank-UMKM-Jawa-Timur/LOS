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
                <th>Tanggal Pengajuan</th>
                <th>Nama Calon Nasabah</th>
                <th>Skor By Sistem</th>
                <th>Posisi Pengajuan</th>
                <th>Jenis Usaha</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data_pengajuan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->average_by_sistem != null ? $item->average_by_sistem : '-'  }}</td>
                    <td>{{ $item->posisi }}</td>
                    <td>{{ $item->jenis_usaha }}</td>
                    <td>
                        @if ($item->status_by_sistem == 'hijau')
                            <p class="text-success">
                                {{ $item->status_by_sistem }}
                            </p>
                        @elseif ($item->status_by_sistem == 'kuning')
                            <p class="text-warning">
                                {{ $item->status_by_sistem }}
                            </p>
                        @elseif ($item->status_by_sistem == 'merah')
                            <p class="text-danger">
                                {{ $item->status_by_sistem }}
                            </p>
                        @else
                            <p class="text-secondary">
                                {{ $item->status_by_sistem }}

                            </p>
                        @endif

                    </td>
                    <td>
                        @if ($item->posisi == 'Review Penyelia')
                        <div class="d-flex">

                            <a href="{{ route('pengajuan.detailjawaban',$item->id_pengajuan) }}" class="btn btn-warning">Tindak lanjut Review Penyelia</a>
                        </div>
                        @elseif ($item->posisi == 'Pincab')
                            <a href="{{ route('pengajuan.check.pincab.status') }}" class="btn btn-info">Tindak lanjut Pincab</a>
                        @elseif ($item->posisi == 'Selesai')
                            <a href="" class="btn btn-success">Selesai </a>
                        @else
                            <div class="d-flex">
                                <a href="{{ route('pengajuan-kredit.edit',$item->id_pengajuan) }}" class="mr-2">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary"
                                        data-toggle="tooltip" title="edit data" data-placement="top"><span
                                            class="fa fa-edit fa-sm"></span></button>
                                </a></i>
                                <a href="{{ route('pengajuan.check.penyeliakredit',$item->id_pengajuan) }}" class="btn btn-warning">Tindak lanjut Review Penyelia</a>
                            </div>

                        @endif
                    </td>
                @empty
                    <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
                </tr>
                @endforelse
        </tbody>
    </table>
    <div class="pull-right">
    </div>
</div>
@endsection
