@extends('layouts.template')
@section('content')
@include('components.notification')

<div class="table-responsive">
    <table class="table table-hover table-custom">
        <thead>
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Nama Lengkap</th>
                <th>Sektor Kredit</th>
                <th>Jenis Usaha</th>
                <th>Jumlah Kredit yang diminta</th>
                <th>Jaminan yang disediakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="7" class="text-center" style="background: rgba(71, 145,254,0.05) !important">Data Kosong</td>
            </tr>
        </tbody>
    </table>
    <div class="pull-right">
    </div>
</div>
@endsection