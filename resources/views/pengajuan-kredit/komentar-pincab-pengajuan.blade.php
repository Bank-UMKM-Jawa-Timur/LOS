@extends('layouts.template')
@section('content')
@include('components.notification')
<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Calon Nasabah</th>
                <th>Jenis Usaha</th>
                <th>Posisi</th>
                <th>Skor Sistem</th>
                <th>Skor Penyelia</th>
                <th>Status Sistem</th>
                <th>Status Penyelia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data_pengajuan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis_usaha }}</td>
                    <td>{{ $item->posisi }}</td>
                    <td>{{ $item->average_by_sistem != null ? $item->average_by_sistem : '-'  }}</td>
                    <td>{{ $item->average_by_penyelia != null ? $item->average_by_penyelia : '-'  }}</td>
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
                            -
                        @endif

                    </td>
                    <td>
                        @if ($item->posisi == 'Review Penyelia')
                            <div class="d-flex">
                                <a href="{{ route('pengajuan.detailjawaban',$item->id_pengajuan) }}" class="mr-2">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary"
                                        data-toggle="tooltip" title="detail data" data-placement="top"><span
                                            class="fa fa-solid fa-info fa-sm"></span></button>
                                </a></i>
                            </div>
                        @elseif ($item->posisi == 'Pincab')
                            <div class="d-flex">
                                <a href="{{ route('pengajuan.check.pincab.status.detail',$item->id_pengajuan) }}" class="mr-2">
                                    <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary"
                                        data-toggle="tooltip" title="detail data" data-placement="top"><span
                                            class="fa fa-solid fa-info fa-sm"></span></button>
                                </a></i>
                                @if ($item->posisi == "Selesai")
                                    <a href="{{ route('pengajuan.change.pincab.status',$item->id_pengajuan) }}" class="btn btn-primary">Selsai</a>
                                @else
                                    <a href="{{ route('pengajuan.change.pincab.status',$item->id_pengajuan) }}" class="btn btn-primary">Tindak lanjut Pincab</a>
                                @endif
                            </div>
                        @elseif ($item->posisi == 'Selesai')
                            <a href="" class="btn btn-success">Selesai </a>
                        @else
                            <a href="{{ route('pengajuan.detailjawaban',$item->id_pengajuan) }}" class="btn btn-primary">Tindak lanjut Review Penyelia</a>
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
