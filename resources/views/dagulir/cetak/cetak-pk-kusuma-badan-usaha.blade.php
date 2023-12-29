<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perjanjian Kredit</title>
    <style>
        body{
            font-size: 15px;
            width: 215mm;
            height: 330mm;
        }
        .heading {
            text-align: center;
            width: 80%
        }
        .heading-1 {
            text-align: right;
            width: 80%
        }

        .no-surat {
            margin-top: -17px;
        }

        .table-perjanjian,
        .table-perjanjian-2,
        .table-perjanjian-3 {
            width: 80%;
        }

        .table-pasal-1,
        .table-pasal-2,
        .table-pasal-3,
        .table-pasal-4,
        .table-pasal-5,
        .table-pasal-6,
        .table-pasal-7,
        .table-pasal-8,
        .table-pasal-9,
        .table-pasal-10,
        .table-pasal-11,
        .table-pasal-12,
        .table-pasal-13 {
            width: 80%;
        }

        @media print {
            footer {page-break-after: always;}
        }

        .table-ttd {
            margin: auto;
            width: 100%;
            padding-top: 5%;
        }
    </style>
</head>
@php
    function rupiah($angka){

	$hasil_rupiah = number_format($angka,2,',','.');
	return $hasil_rupiah;
    }

    $namaBulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    $nilai = 0;

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        $temp = '';
        if ($nilai < 12) {
            $temp = ' ' . $huruf[$nilai];
        } elseif ($nilai < 20) {
            $temp = penyebut($nilai - 10) . ' belas';
        } elseif ($nilai < 100) {
            $temp = penyebut($nilai / 10) . ' puluh' . penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            $temp = ' seratus' . penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . ' ratus' . penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            $temp = ' seribu' . penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . ' ribu' . penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . ' juta' . penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . ' milyar' . penyebut(fmod($nilai, 1000000000));
        } elseif ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . ' trilyun' . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
@endphp
<body onload="printPage()">
    <div class="data-surat">
        <div class="heading-1">
            <h4>(Badan Usaha)</h4>
        </div>
        <table class="table-header-tgl">
            <tr>
                <td>Kepada</td>
                <td style="text-align: right"></td>
                <td style="width: 34%; text-align: right;">{{ $dataCabang->cabang }}, tanggal {{ $tgl }}</td>
                <td style="text-align: right;"></td>
            </tr>
        </table>
        <table class="table-header-yth">
            <tr>
                <td>Pimpinan Cabang</td>
                <td>Bank BPR Jatim</td>
            </tr>
        </table>
        <table class="table-header-almt">
            <tr>
                <td>Di -</td>
            </tr>
            <tr>
                <td></td>
                <td>. . . . . . . . . . . . . . .</td>
            </tr>
        </table>

        <table class="table-perjanjian">
            <tr>
                <td style="width: 7%">Perihal </td>
                <td style="width: 1%">:</td>
                <td><h4 class="tittle-page"><b>Permohonan Kredit KUSUMA (Modal Kerja/Investasi/Pertanian Non PKPJ)</b></h4></td>
            </tr>
        </table>

        <p>Dengan Hormat, </p>
        <p>Yang bertanda tangan dibawah ini: </p>

        <table class="table-perjanjian">
            <tr>
                <td style="width: 20%">Nama CV/PT</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .(lama / baru)</td>
            </tr>
            <tr>
                <td style="width: 20%">Nama ibu kandung</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
            <tr>
                <td style="width: 20%">Alamat</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
            <tr>
                <td style="width: 20%">No Telepon</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
            <tr>
                <td style="width: 20%">Nomor KTP/SIM</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
            <tr>
                <td style="width: 20%">Pekerjaan</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
            <tr>
                <td style="width: 20%">Jenis Usaha</td>
                <td style="width: 1%">:</td>
                <td>. . . . . . . . . . . . . . . . . . . . . . . . .</td>
            </tr>
        </table>

        <table class="table-perjanjian">
            <tr>
                <td>
                    Dengan ini mengajukan permohonan pinjaman/kredit KUSUMA (Modal Kerja / Investasi) pada BANK BPR Jatim,
                </td>
            </tr>
        </table>

        <br>

        <table class="table-perjanjian-2">
            <tr>
                <td style="width: 20%">Sejumlah</td>
                <td style="width: 1%">:</td>
                <td>{{'Rp '. number_format($dataNasabah->jumlah_kredit, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="width: 20%"></td>
                <td style="width: 1%"></td>
                <td>({{penyebut($dataNasabah->jumlah_kredit)}})</td>
            </tr>
            <tr>
                <td style="width: 20%">Jangka waktu</td>
                <td style="width: 1%">:</td>
                <td>{{$dataNasabah->tenor_yang_diminta}} bulan</td>
            </tr>
            <tr>
                <td style="width: 20%">Tujuan penggunaan</td>
                <td style="width: 1%">:</td>
                <td>{{$dataNasabah->tujuan_kredit}}</td>
            </tr>
        </table>

        <table class="table-perjanjian">
            <tr>
                <td>
                    Sebagai bahan pertimbangan dan kelengkapan administrasi, kami lampirkan :
                </td>
            </tr>
        </table>
        <table class="table-perjanjian-3">
            <tr>
                <td style="width: 3%">1. </td>
                <td colspan="3">1 lembar foto ukuran 4x6 (suami & itri);</td>
            </tr>
            <tr>
                <td style="width: 3%">2. </td>
                <td colspan="3">1 lembar fotokopi KTP (suami & itri);</td>
            </tr>
            <tr>
                <td style="width: 3%">3. </td>
                <td colspan="3">1 lembar fotokopi Surat Nikah;</td>
            </tr>
            <tr>
                <td style="width: 3%">4. </td>
                <td colspan="3">1 lembar fotokopi KSK;</td>
            </tr>
            <tr>
                <td style="width: 3%">5. </td>
                <td colspan="3">Surat Keterangan Usaha Kantor Desa/Kesuluruhan, sesuai ketentuan yang berlaku;</td>
            </tr>
            <tr>
                <td style="width: 3%">6. </td>
                <td colspan="3">Surat Keterangan Usaha Harga Pasar Tanah dari Kantor Desa/Kesuluruhan;</td>
            </tr>
            <tr>
                <td style="width: 3%">7. </td>
                <td colspan="3">Fotokopi legalitas usaha (SIUP / izin usaha yang diperoleh secara Online / TDP / NIB / NPWP) sesuai ketentuan yang berlaku;</td>
            </tr>
            <tr>
                <td style="width: 3%">8. </td>
                <td colspan="3">Fotokopi bukti kepimilikan jaminan (BPKB & STNK / SHGB / SHM & SPPT PBB terakhir / faktur / nota pembelian / surat pernyataan kepimilikan );</td>
            </tr>
            <tr>
                <td style="width: 3%">9. </td>
                <td colspan="3">Fotokopi KTP, KSK, Surat Nikah Pemilik Jaminan;</td>
            </tr>
            <tr>
                <td style="width: 3%">10. </td>
                <td colspan="3">Fotokopi transaksi buku tabungan 3 bulan terakhir;</td>
            </tr>
            <tr>
                <td style="width: 3%">12. </td>
                <td colspan="3">. . . . . . . . . .  . . . . ;</td>
            </tr>
        </table>
        <table class="table-perjanjian">
            <tr>
                <td>
                    Demikian permohonan ini dan atas perhatiannya kami sampaikan terimakasih.
                </td>
            </tr>
        </table>

        <table class="table-ttd">
            <tr>
                <th style="font-weight: 500; width: 100%;">Hormat Kami,</th>
            </tr>
            <tr>
                <td style="padding-top: 50px; padding-bottom: 50px;"></td>
                <td style="padding-top: 50px; padding-bottom: 50px; text-align: center; color: gainsboro"></td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>(.....................................)</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
