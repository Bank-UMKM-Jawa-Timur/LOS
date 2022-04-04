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
                        @if ($item->status == 'hijau')
                            <p class="text-success">
                                {{ $item->status }}
                            </p>
                        @elseif ($item->status == 'kuning')
                            <p class="text-warning">
                                {{ $item->status }}
                            </p>
                        @elseif ($item->status == 'merah')
                            <p class="text-danger">
                                {{ $item->status }}
                            </p>
                        @else
                            <p class="text-secondary">
                                {{ $item->status }}

                            </p>
                        @endif

                    </td>
                    <td>
                        @if ($item->posisi == 'Review Penyelia')
                            <a href="" class="btn btn-primary">Tindak lanjut Review Penyelia</a>
                        @elseif ($item->posisi == 'Pincab')
                            <a href="" class="btn btn-info">Tindak lanjut Pincab</a>
                        @elseif ($item->posisi == 'Selesai')
                            <a href="" class="btn btn-success">Selesai </a>
                        @else
                            <a href="{{ route('pengajuan-kredit.edit',$item->id_pengajuan) }}" class="mr-2">
                                <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm"
                                    data-toggle="tooltip" title="edit data" data-placement="top"><span
                                        class="fa fa-edit fa-sm"></span></button>
                            </a></i>

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
