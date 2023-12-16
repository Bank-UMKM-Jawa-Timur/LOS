<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Pemberitahuan Persetujuan Kredit</title>
    <style>
        body{
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

        .table-header-tgl {
            width: 100%;
        }

        .table-header-perihal {
            width: 100%;
        }

        .table-body {
            width: 100%;
        }

        .table-body-2 {
            width: 100%;
            text-align: justify
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
    function rupiah($angka){

        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function getKaryawan($nip){
        // from api
        $host = env('HCS_HOST');
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
        <table class="table-header-tgl">
            <tr>
                <td style="width: 7%">Nomor</td>
                <td style="width: 1%">:</td>
                <td style="width: 50%">............/SPPK/{{ $dataCabang->kode_cabang }}/{{ date('m', strtotime($tglCetak->tgl_cetak_sppk)) }}/{{ date('Y', strtotime($tglCetak->tgl_cetak_sppk)) }}</td>
                <td style="width: 13%; text-align: right">{{ $dataCabang->cabang }}</td>
                <td style="width: 1%">,</td>
                <td>tanggal {{ $tgl }}</td>
            </tr>
            <tr>
                <td>Kepada</td>
            </tr>
        </table>

        <table class="table-header-yth">
            <tr>
                <td style="width: 10px">Yth</td>
                <td style="padding-left: -100px">.</td>
                <td>{{ $dataNasabah->nama }}</td>
            </tr>
        </table>

        <table class="table-header-almt">
            <tr>
                <td>Di -</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    Kab. {{ Str::title($dataNasabah->kabupaten) }}, Kec. {{ Str::title($dataNasabah->kecamatan) }}, Desa. {{ Str::title($dataNasabah->desa) }}, Alamat.
                    {{ $dataNasabah->alamat_rumah }}</td>
            </tr>
        </table>

        <br>

        <table class="table-header-perihal">
            <tr>
                <td style="width: 7%">Perihal</td>
                <td style="width: 1%">:</td>
                <td><b><u>Surat Pemberitahuan Persetujuan Kredit</u></b></td>
            </tr>
        </table>

        <p>Dengan ini kami beritahukan, bahwa permohonan kredit saudara sesuai buku register nomor ............/{{ $dataCabang->kode_cabang }}/SPPK/{{ date('m', strtotime($tglCetak->tgl_cetak_sppk)) }}/{{ date('Y', strtotime($tglCetak->tgl_cetak_sppk)) }} tanggal {{ $tgl }},
           pada prinsipnya dapat kami setujui dengan ketentuan sebagai berikut:</p>

        <table class="table-body">
            <tr>
                <td>1.</td>
                <td style="width: 25%">Bentuk Pinjaman</td>
                <td style="width: 2%">:</td>
                <td>Angsuran</td>
            </tr>
            <tr>
                <td>2.</td>
                <td style="width: 25%">Tujuan Kredit</td>
                <td style="width: 2%">:</td>
                <td>Konsumsi</td>
            </tr>
            <tr>
                <td>3.</td>
                <td style="width: 25%">Untuk Keperluan</td>
                <td style="width: 2%">:</td>
                <td><b>Pembelian Kendaraan Bermotor</b></td>
            </tr>
            <tr>
                <td>4.</td>
                <td style="width: 25%">Besarnya Pinjaman</td>
                <td style="width: 2%">:</td>
                <td>Rp. {{ rupiah($dataNasabah->nominal) }}</td>
            </tr>
            <tr>
                <td>5.</td>
                <td style="width: 25%">Jangka Waktu Pinjaman</td>
                <td style="width: 2%">:</td>
                <td>{{ intval($dataNasabah->jangka_waktu) }} bulan</td>
            </tr>
            <tr>
                <td>6.</td>
                <td style="width: 25%">Bunga Pinjaman</td>
                <td style="width: 2%">:</td>
                <td>...... p.a anuitas/efektif/floating <sup>2</sup>) rate</td>
            </tr>
            <tr>
                <td>7.</td>
                <td style="width: 25%">Angsuran Perbulan</td>
                <td style="width: 2%">:</td>
                <td>Rp. {{ $installment ? rupiah(intval($installment?->opsi_text)) : 0 }}</td>
            </tr>
            <tr>
                <td>8.</td>
                <td style="width: 25%">Denda</td>
                <td style="width: 2%">:</td>
                <td >
                    <ul>
                        <li>Terhadap kelambatan pembayaran angsuaran kredit lebih dari 7 (tujuh) hari sesudah tanggal angsuran yang telah ditentukan
                            dikenakan denda sebesar 1% (satu persen) perbulan dari jumlah angsuran pokok dan bunga yang harus dibayar dan dihitung secara harian.
                        </li>
                        <li>Terhadap kelambatan pelunasan baik hutang pokok maupun bunga dikenakan denda sebesar 50% (lima puluh persen) dari suku bunga yang berlaku atas sisa kredit yang bersangkutan.</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>9.</td>
                <td style="width: 25%">Biaya - Biaya</td>
                <td style="width: 2%">:</td>
                <td>
                    <table>
                        <tr>
                            <td>-</td>
                            <td style="width: 70%">Provisi</td>
                            <td>:</td>
                            <td>Rp. ...................</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td style="width: 70%">Administrasi</td>
                            <td>:</td>
                            <td>Rp. ...................</td>
                        </tr>
                        <tr>
                            <td>-</td>
                            <td style="width: 70%">Asuransi jiwa, Asuransi kredit</td>
                            <td>:</td>
                            <td>Rp. ...................</td>
                        </tr>
                        {{-- <tr>
                            <td></td>
                            <td style="width: 70%"></td>
                            <td></td>
                            <td><hr style="margin: 2px 0px -2px 0px"></td>
                        </tr> --}}
                        <tr>
                            <td></td>
                            <td style="width: 70%"></td>
                            <td></td>
                            <td>Rp. ................... </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>10.</td>
                <td style="width: 25%">Jaminan Kredit Berupa <sup>3</sup>)</td>
                <td style="width: 2%">:</td>
                <td>Asli BPKB Kendaraan Bermotor yang dibeli disertai faktur pembelian atas nama yang tercantum pada BPKB</td>
            </tr>
        </table>

        <table class="table-body-2">
            <tr>
                <td style="vertical-align: text-top"><b>11.</b></td>
                <td><b>Debitur diwajibkan membuka rekening tabungan yang digunakan sebagai rekening penampungan realisasi kredit, angsuran kredit Bank dan pembayaran kendaraan.</b></td>
            </tr>
            <tr>
                <td style="vertical-align: text-top">12.</td>
                <td>Semua surat-surat asli dari barang-barang yang dijaminkan harus diserahkan pada Bank dan pemilik jaminan ikut menandatangani.</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top">13.</td>
                <td>Permohonan kredit Saudara dapat direalisir paling awal pada 1 hari kerja setelah {{ $tgl }}</td>
            </tr>
            <tr>
                <td style="vertical-align: text-top">14.</td>
                <td>Sesuai dengan ketentuan perkreditan yang berlaku.<br>
                    Selanjutnya apabila ketentuan-ketentuan tersebut di atas Suadara setujui, maka lembar kedua dari surat ini, sesudah ditandatangani harap dikirim kepada kami sebagai tanda persetujuan saudara.<br>
                    <br>Demikian untuk menjadikan saudara maklum
                </td>
            </tr>
        </table>

        <table class="table-ttd">
            <tr>
                <th style="font-weight: 500; width: 50%;"><br>DEBITUR</th>
                <th style="font-weight: 500; width: 50%;">PT. Bank Perkreditan Rakyat Jawa Timur <br>Cabang {{ $dataCabang->cabang }}</th>
            </tr>
            <tr>
                <td style="text-align: center; padding-top: 100px">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>({{ strtoupper($dataNasabah->nama) }})</td>
                        </tr>
                        <tr>
                            <td></td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center; padding-top: 100px">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>({{ getKaryawan($dataPincab[0]['nip']) }})</td>
                            <td>({{ getKaryawan($dataPenyelia[0]['nip']) }})</td>
                        </tr>
                        <tr>
                            <td>Pemimpin Cabang</td>
                            <td>Penyelia Kredit</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table-footer">
            <tr>
                <td><b><u><i>Tindasan:</i></u></b></td>
            </tr>
            <tr>
                <td><i>Penyelia Umum & Akuntansi</i></td>
            </tr>
        </table>

        <table class="table-footer-2">
            <tr>
                <td><b><u><i>Catatan:</i></u></b></td>
            </tr>
            <tr>
                <td><i>1) Hapus bila tidak diperlukan</i></td>
            </tr>
            <tr>
                <td><i>2) Coret yang tidak diperlukan</i></td>
            </tr>
            <tr>
                <td><i>3) Diisi dengan data yang informatif, singkat, dan jelas</i></td>
            </tr>
        </table>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
{{-- <script>
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
</script> --}}
</html>
