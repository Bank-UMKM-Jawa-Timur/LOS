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
                <th>Jenis Usaha</th>
                <th>Posisi</th>
                <th>Durasi Penyelia</th>
                <th>Durasi Pincab</th>
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
                    <td>{{ $item->jenis_usaha }}</td>
                    <td>{{ $item->posisi }}</td>
                    <td>
                        @php
                            $rentangPenyelia = \App\Models\PengajuanModel::find($item->id);
                            $awal = date_create($rentangPenyelia->tanggal) ;
                            $akhir = date_create($rentangPenyelia->tanggal_review_penyelia);
                            $interval = $awal->diff($akhir);
                            $result_rentang = $interval->format('%a');
                        @endphp
                        {{-- {{ $rentangPenyelia }} --}}
                        {{ $item->tanggal_review_penyelia != null ? $result_rentang.' hari' : '-' }}
                    </td>
                    <td>
                        @php
                            $rentangPincab = \App\Models\PengajuanModel::find($item->id);
                            $awal = date_create(date(now()));
                            $akhir = date_create($rentangPincab->tanggal_review_pincab);
                            $interval = $awal->diff($akhir);
                            $result_rentang_pincab = $interval->format('%a');
                        @endphp
                        {{ $item->tanggal_review_pincab != null ? $result_rentang_pincab.' hari' : '-' }}
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
                        @if ($item->posisi != 'selesai')
                            <p class="text-warning">On Progress</p>
                        @else
                            <p class="text-success">Selesai</p>
                        @endif
                    </td>
                    <td>
                        @if ($item->posisi == 'Review Penyelia')
                            <div class="d-flex">
                                <a href="{{ route('pengajuan.check.pincab',$item->id_pengajuan) }}" class="btn btn-info">Tindak lanjut Pincab</a>

                            </div>
                        @elseif ($item->posisi == 'Pincab')
                            <div class="d-flex">
                                @if (auth()->user()->role == 'Pincab')
                                    <a href="{{ route('pengajuan.check.pincab.status.detail',$item->id_pengajuan) }}" class="btn btn-rgb-primary mr-2">
                                        Detail data
                                    </a>
                                @endif
                                @if ($item->posisi == "Selesai")
                                    <button href="{{ route('pengajuan.change.pincab.status',$item->id_pengajuan) }}" class="btn btn-primary">Selesai</button>
                                @else
                                    <a href="{{ route('pengajuan.change.pincab.status',$item->id_pengajuan) }}" class="btn btn-primary">Tindak lanjut Pincab</a>
                                @endif
                            </div>
                        @elseif ($item->posisi == 'Selesai')
                            <button disabled href="" class="btn btn-success" >Selesai </button>
                        @else
                            <a href="{{ route('pengajuan.detailjawaban',$item->id_pengajuan) }}" class="btn btn-warning">Tindak lanjut Staf Kredit</a>
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
