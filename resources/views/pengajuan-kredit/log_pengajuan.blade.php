@extends('layouts.template')
@section('content')
    @include('components.notification')

    <style>
        .jrk {
            width: 200px;
        }

        .conten-timeline td {
            padding-top: 10px;
            border-bottom: 1px solid #eeeeee;
        }

        .title-log {
            font-size: 20px;
            font-weight: bold;
        }
    </style>

    <div class="card mb-3">
        <div class="card-header bg-info color-white font-weight-bold" data-toggle="collapse" href="#logPengajuan">
            Judul Pengajuan 1
        </div>
        <div class="card-body collapse show head-timeline multi-collapse" id="logPengajuan">
            <div class="timeline">
                <div class="conten-timeline right">
                    <div class="content">
                        <h2 class="title-log">21/April/2023</h2>
                        <table>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                    <div class="content">
                        <h2 class="title-log">19/April/2023</h2>
                        <table>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                            <tr>
                                <td class="jrk"><span class="fa fa-clock mr-1"></span> 10:30:00</td>
                                <td><span class="fa fa-check mr-1"></span> Telah Di Konfirmasi Oleh Penyelia</td>
                            </tr>
                        </table>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
