@extends('layouts.template')
@section('content')
@include('components.notification')

<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                <th>Nama Calon Nasabah</th>
                <th>Jenis Usaha</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @forelse ($data_pengajuan as $item)
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis_usaha }}</td>
                    <td>
                        <a href="{{ route('pengajuan.detailjawaban',$item->id_pengajuan) }}" class="mr-2">
                            <button type="button" id="PopoverCustomT-1" class="btn btn-rgb-primary btn-sm"
                                data-toggle="tooltip" title="detail data" data-placement="top"><span
                                    class="fa fa-solid fa-info fa-sm"></span></button>
                        </a></i>
                    </td>
                @empty
                    <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
                @endforelse
            </tr>
        </tbody>
    </table>
    <div class="pull-right">
    </div>
</div>
@endsection
