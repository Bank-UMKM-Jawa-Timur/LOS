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
                <th>Nama Nasabah</th>
                <th>Posisi</th>
                <th>Durasi</th>
                <th>Skor</th>
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
                    <td>
                        @if ($item->posisi == 'Proses Input Data')
                            Staff
                        @elseif ($item->posisi == 'Review Penyelia')
                            Penyelia
                        @else
                            Pincab
                        @endif
                    </td>
                    <td>
                        @if ($item->posisi == 'Proses Input Data')
                            @php
                                $rentangStaff = \App\Models\PengajuanModel::find($item->id);
                                $awal = date_create(date(now()));
                                $akhir = date_create($rentangStaff->tanggal);
                                $interval = $awal->diff($akhir);
                                $result_rentang = $interval->format('%a');
                            @endphp
                            {{-- {{ $rentangPenyelia }} --}}
                            {{ $result_rentang.' hari' }}
                        @elseif ($item->posisi == 'Review Penyelia')
                            @php
                                $rentangPenyelia = \App\Models\PengajuanModel::find($item->id);
                                $awal = date_create(date(now()));
                                $akhir = date_create($rentangPenyelia->tanggal_review_penyelia);
                                $interval = $awal->diff($akhir);
                                $result_rentang = $interval->format('%a');
                            @endphp
                                {{ $item->tanggal_review_penyelia != null ? $result_rentang.' hari' : '-' }}
                        @else
                            @php
                                $rentangPincab = \App\Models\PengajuanModel::find($item->id);
                                $awal = date_create(date(now()));
                                $akhir = date_create($rentangPincab->tanggal_review_pincab);
                                $interval = $awal->diff($akhir);
                                $result_rentang_pincab = $interval->format('%a');
                            @endphp
                            {{ $item->tanggal_review_pincab != null ? $result_rentang_pincab.' hari' : '-' }}
                        @endif

                    </td>
                    <td>
                        @if ($item->average_by_penyelia != null)
                            @if ($item->status == 'hijau')
                                <p class="text-success">
                                    {{ $item->average_by_penyelia }}
                                </p>
                            @elseif ($item->status == 'kuning')
                                <p class="text-warning">
                                    {{ $item->average_by_penyelia }}
                                </p>
                            @elseif ($item->status == 'merah')
                                <p class="text-danger">
                                    {{ $item->average_by_penyelia }}
                                </p>
                            @else
                                <p class="text-secondary">
                                    {{ $item->average_by_penyelia }}
                                </p>
                            @endif
                        @else
                            @if ($item->status_by_sistem == 'hijau')
                                <p class="text-success">
                                    {{ $item->average_by_sistem }}
                                </p>
                            @elseif ($item->status_by_sistem == 'kuning')
                                <p class="text-warning">
                                    {{ $item->average_by_sistem }}
                                </p>
                            @elseif ($item->status_by_sistem == 'merah')
                                <p class="text-danger">
                                    {{ $item->average_by_sistem }}
                                </p>
                            @else
                                <p class="text-secondary">
                                    {{ $item->average_by_sistem }}
                                </p>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($item->posisi === 'Selesai')
                            <p class="text-success">Selesai</p>
                        @else
                            <p class="text-warning">On Progress</p>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                        @if ($item->posisi == 'Proses Input Data')
                            <a href="{{ route('pengajuan-kredit.edit',$item->id_pengajuan) }}" class="btn btn-rgb-primary mr-2">
                                Edit data
                            </a>
                            <a href="{{ route('pengajuan.check.penyeliakredit',$item->id_pengajuan) }}" class="btn btn-warning">Tindak lanjut Review Penyelia</a>
                        @endif
                            <div class="px-2">
                                <a target="_blank" href="{{ route('cetak',$item->id_pengajuan) }}" class="btn btn-info">Cetak</a>
                            </div>
                        </div>
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
