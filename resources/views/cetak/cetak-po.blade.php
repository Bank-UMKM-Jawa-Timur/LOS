<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemesanan Kendaraan Bermotor</title>
    <style>
        body{
            font-size: 20px;
            width: 215mm;
            height: 330mm;
        }
        table{
            border-spacing: 0;
        }
        tr{
            vertical-align: top;
        }
        @media print {
            html, body {
                height: 99%;
            }
        }
        .data-surat {
            width: 100%;
            margin: 0 auto;
        }

        .table-header-kota {
            width: 100%;
        }

        .table-header-perihal {
            width: 100%;
        }

        .table-body {
            width: 100%;
        }

        .table-ttd {
            width: 100%;
        }

        ul {
            list-style-type: none;
            margin: 3px 3px 3px 3px;
            padding-left: 0;
        }

        li {
            margin: 0 0 0 10px;
            padding: 0;
            text-indent: -0.6em;
        }

        li::before {
            content: "- ";
        }

        p {
            text-align: justify;
        }
    </style>
</head>
@php
    function getKaryawan($nip){
        // from api
        $host = env('HCS_HOST','https://hcs.bankumkm.id');
        $apiURL = $host . '/api/karyawan';

        $response = Http::get($apiURL, [
            'nip' => $nip,
        ]);

        $statusCode = $response->status();

        if ($statusCode === 200) {
            $responseData = $response->json();
            $nama = $responseData['data']['nama'];
            return $nama;
        } else {
            return null;
        }
    }
@endphp
<body onload="printPage()">
    <div class="data-surat">
        <table class="table-header-kota" style="margin-bottom: 10px;">
            <tr>
                <td style="width: 0.5%">{{ $dataCabang->cabang }}</td>
            </tr>
            <tr>
                <td style="width: 0.5%">Kota, {{ $tgl }}</td>
            </tr>
        </table>

        <table class="table-header-yth">
            <tr>
                <td>Kepada Yth,</td>
            </tr>
            <tr>
                <td>PT. BJSC Aquagro Mandiri</td>
            </tr>
            <tr>
                <td>Melalui PT. BPR JATIM Kantor Cabang {{ $dataCabang->cabang }}</td>
            </tr>
        </table>

        <table class="table-header-almt">
            <tr>
                <td>{{ $dataCabang->alamat }}</td>
            </tr>
        </table>

        <table class="table-header-almt-2">
            <tr>
                <td>Di</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    Kab. {{ Str::title($dataNasabah->kabupaten) }}, Kec. {{ Str::title($dataNasabah->kecamatan) }}, Desa. {{ Str::title($dataNasabah->desa) }}, Alamat.
                    {{ $dataNasabah->alamat_rumah }}
                </td>
            </tr>
        </table>

        <br>

        <table class="table-header-perihal" style="margin-bottom: 10px">
            <tr>
                <td style="width: 7%">Perihal</td>
                <td style="width: 1%">:</td>
                <td><b>Pemesanan Kendaraan Bermotor</b></td>
            </tr>
            <tr>
                <td colspan="3">
                    <br>Berdasarkan Surat Pemberitahuan Persetujuan Kredit (SPPK) Nomor : ............/{{ $dataCabang->kode_cabang }}/SPPK/{{ date('m', strtotime($tglCetak->tgl_cetak_sppk)) }}/{{ date('Y', strtotime($tglCetak->tgl_cetak_sppk)) }}, tanggal {{ $tgl }}, bersama ini saya melalui PT. BPR Jatim Kantor Cabang {{ $dataCabang->cabang }}, melakukan pemesanan kendaraan bermotor kepada PT. BJSC Aquagro Mandiri sebagai berikut :
                </td>
            </tr>
        </table>

        {{-- <p style="vertical-align: ">
        </p> --}}

        <table>
            <tr>
                <td>Jenis Kendaraan roda 2 :</td>
            </tr>
        </table>

        <table class="table-body">
            <tr>
                <td style="width: 13%">Merk/Type</td>
                <td style="width: 2%">:</td>
                <td>{{ $dataPO?->merk }}</td>
            </tr>
            <tr>
                <td style="width: 13%">Tahun</td>
                <td style="width: 2%">:</td>
                <td>{{ $dataPO?->tahun_kendaraan }}</td>
            </tr>
            <tr>
                <td style="width: 13%">Warna</td>
                <td style="width: 2%">:</td>
                <td>{{ $dataPO?->warna }}</td>
            </tr>
            <tr>
                <td style="width: 13%">Keterangan</td>
                <td style="width: 2%">:</td>
                <td>{{ $dataPO?->keterangan }} sejumlah {{ $dataPO?->jumlah }}</td>
            </tr>
            <tr>
                <td style="width: 13%">Harga</td>
                <td style="width: 2%">:</td>
                <td>Rp. {{ number_format($dataPO?->harga,0,',','.') }}</td>
            </tr>
        </table>

        <p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        <br>

        <table class="table-ttd">
            <tr>
                <th style="font-weight: 500; width: 50%;">PT. BPR JATIM <br>CABANG {{ strtoupper($dataCabang->cabang) }}</th>
                <th style="font-weight: 500; width: 50%;">Debitur</th>
            </tr>
            <tr>
                <td style="text-align: center; padding-top: 70px">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>__________________________</td>
                        </tr>
                        <tr>
                            <td>{{ getKaryawan($dataPincab[0]['nip']) }}</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; padding-top: 70px">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>________________________</td>
                        </tr>
                        <tr>
                            <td>{{ $dataNasabah->nama }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script>
    function printPage() {
        // Show print dialog
        window.print();

        // Generate PDF
        const doc = new jsPDF();
        const element = document.querySelector('.data-surat');
        doc.html(element, {
            callback: function (doc) {
                doc.save('Surat Pemberitahuan Persetujuan Kredit.pdf');
            }
        });
    }
</script>
</html>
