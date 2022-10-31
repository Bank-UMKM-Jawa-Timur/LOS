@extends('layouts.template')
@section('content')
@include('components.notification')
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
                            @if ($result_rentang != 0)
                                @if ($result_rentang == 1 || $result_rentang == 2 || $result_rentang == 3)
                                    <font class="text-success">{{ $result_rentang.' hari' }}</font>
                                @elseif ($result_rentang == 4 || $result_rentang == 5 || $result_rentang == 6)
                                    <font class="text-warning">{{ $result_rentang.' hari' }}</font>
                                @else
                                    <font class="text-danger">{{ $result_rentang.' hari' }}</font>
                                @endif
                            @else
                                {{ '-' }}
                            @endif
                        @elseif ($item->posisi == 'Review Penyelia')
                            @php
                                $rentangPenyelia = \App\Models\PengajuanModel::find($item->id);
                                $awal = date_create(date(now()));
                                $akhir = date_create($rentangPenyelia->tanggal_review_penyelia);
                                $interval = $awal->diff($akhir);
                                $result_rentang = $interval->format('%a');
                            @endphp
                                @if ($item->tanggal_review_penyelia != null)
                                    @if ($result_rentang != 0)
                                        @if ($result_rentang == 1 || $result_rentang == 2 || $result_rentang == 3)
                                            <font class="text-success">{{ $result_rentang.' hari' }}</font>
                                        @elseif ($result_rentang == 4 || $result_rentang == 5 || $result_rentang == 6)
                                            <font class="text-warning">{{ $result_rentang.' hari' }}</font>
                                        @else
                                            <font class="text-danger">{{ $result_rentang.' hari' }}</font>
                                        @endif
                                    @else
                                        {{ '-' }}
                                    @endif
                                @endif
                        @else
                            @php
                                $rentangPincab = \App\Models\PengajuanModel::find($item->id);
                                $awal = date_create(date(now()));
                                $akhir = date_create($rentangPincab->tanggal_review_pincab);
                                $interval = $awal->diff($akhir);
                                $result_rentang_pincab = $interval->format('%a');
                            @endphp
                            @if ($item->tanggal_review_pincab != null)
                                @if ($result_rentang_pincab != 0)
                                    @if ($result_rentang_pincab == 1 || $result_rentang_pincab == 2 || $result_rentang_pincab == 3)
                                        <font class="text-success">{{ $result_rentang_pincab.' hari' }}</font>
                                    @elseif ($result_rentang_pincab == 4 || $result_rentang_pincab == 5 || $result_rentang_pincab == 6)
                                        <font class="text-warning">{{ $result_rentang_pincab.' hari' }}</font>
                                    @else
                                        <font class="text-danger">{{ $result_rentang_pincab.' hari' }}</font>
                                    @endif
                                @else
                                    {{ '-' }}
                                @endif
                            @endif
                        @endif

                    </td>
                    <td>
                        @if ($item->average_by_penyelia != null)
                            @if ($item->status == 'hijau')
                                <font class="text-success">
                                    {{ $item->average_by_penyelia }}
                                </font>
                            @elseif ($item->status == 'kuning')
                                <font class="text-warning">
                                    {{ $item->average_by_penyelia }}
                                </font>
                            @elseif ($item->status == 'merah')
                                <font class="text-danger">
                                    {{ $item->average_by_penyelia }}
                                </font>
                            @else
                                <font class="text-secondary">
                                    {{ $item->average_by_penyelia }}
                                </font>
                            @endif
                        @else
                            @if ($item->status_by_sistem == 'hijau')
                                <font class="text-success">
                                    {{ $item->average_by_sistem }}
                                </font>
                            @elseif ($item->status_by_sistem == 'kuning')
                                <font class="text-warning">
                                    {{ $item->average_by_sistem }}
                                </font>
                            @elseif ($item->status_by_sistem == 'merah')
                                <font class="text-danger">
                                    {{ $item->average_by_sistem }}
                                </font>
                            @else
                                <font class="text-secondary">
                                    {{ $item->average_by_sistem }}
                                </font>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if ($item->posisi == 'Selesai')
                            <font class="text-success">Selesai</font>
                        @elseif ($item->posisi == 'Ditolak')
                            <font class="text-success">Ditolak</font>
                        @else
                            <font class="text-warning">On Progress</font>
                        @endif
                    </td>
                    <td>
                        @if ($item->posisi == 'Pincab')
                            <div class="d-flex">
                                @if (auth()->user()->role == 'Pincab')
                                    <a href="{{ route('pengajuan.check.pincab.status.detail',$item->id_pengajuan) }}" class="btn btn-rgb-primary mr-2">
                                        Review
                                    </a>
                                    @if ($item->posisi == "Selesai")
                                        <button href="{{ route('pengajuan.change.pincab.status',$item->id_pengajuan) }}" class="btn btn-primary">Selesai</button>
                                    @else
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-id="{{ $item->id_pengajuan }}" data-target="#exampleModal">
                                            Disetujui/Ditolak
                                        </button>
                                    @endif
                                @endif
                                <div class="px-2">
                                    <a href="{{ route('cetak',$item->id_pengajuan) }}" target="_blank" class="btn btn-info">Cetak</a>
                                </div>

                            </div>
                        @elseif ($item->posisi == 'Selesai')
                            <div class="d-flex p-2">
                                {{-- <div class="px-2">
                                    <button disabled href="" class="btn btn-success" >Selesai </button>
                                </div> --}}
                                <div class="">
                                    <a href="{{ route('cetak',$item->id_pengajuan) }}" class="btn btn-info" target="_blank">Cetak</a>
                                </div>
                            </div>
                        @elseif ($item->posisi == 'Ditolak')
                            <div class="d-flex p-2">
                                {{-- <div class="px-2">
                                    <button disabled href="" class="btn btn-danger" >Ditolak </button>
                                </div> --}}
                                <div class="">
                                    <a href="{{ route('cetak',$item->id_pengajuan) }}" class="btn btn-info" target="_blank">Cetak</a>
                                </div>
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
@include('layouts.modal')
@endsection

@section('modal ')
    @include('layouts.modal')
@endsection
