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
            width: 80%;
            padding-top: 5%;
        }
        .page-break {
            page-break-after: always;
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
    $namaHari = [
        'Sunday' => 'Minggu',
        'Monday' => 'senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu',
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

    function getKaryawan($nip){
        // from api
        $konfiAPI = DB::table('api_configuration')->first();
        $host = $konfiAPI->hcs_host;
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
        <div class="heading">
            <h3>PERJANJIAN KREDIT DAN PENGAKUAN HUTANG</h3>
            <p class="no-surat">Nomor : ......../{{strtoupper($dataUmum->skema_kredit)}}/{{ $dataCabang->cabang }}/{{$namaBulan[$bulan]}}/{{$tahun}}</p>
        </div>

        @php
            $today = new DateTime();
            // $hariIni ->format('l F Y, H:i')
            $hariIni = $today->format('l')
        @endphp

        <p>Pada hari ini {{$namaHari[$hariIni]}}, tanggal {{ date('d') . '-' . $namaBulan[date('m')] . '-' . date('Y') }}, yang bertanda tangan dibawah ini:</p>

        <table class="table-perjanjian">
            <tr>
                <td style="width: 3%">1. </td>
                <td style="width: 20%">Nama</td>
                <td style="width: 1%">:</td>
                <td>
                    ({{ getKaryawan($dataPincab[0]['nip']) }})
                </td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">Jabatan</td>
                <td style="width: 1%">:</td>
                <td>Pemimpin Cabang</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td style="width: 3%">2. </td>
                <td style="width: 20%">Nama</td>
                <td style="width: 1%">:</td>
                <td>
                    ({{ getKaryawan($dataPenyelia[0]['nip']) }})
                </td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">Jabatan</td>
                <td style="width: 1%">:</td>
                <td>Penyelia Kredit Wilayah</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table class="table-perjanjian">
            <tr>
                <td style="vertical-align: top; width: 3%"></td>
                <td>
                    Dalam hal ini masing-masing dan secara berturut-turut bertindak dalam jabatannya seperti tersebut berdasarkan Surat Keputusan Nomor : . . . . . . . . . . . . . . . . . . . . . tanggal . . . . . . . . . . . . .dan Nomor : . . . . . . . . . . . . . . . .  . . . . tanggal . . . . . . . . . . . . . . .  serta Akta Surat Kuasa Nomor :  . . . . . . . . . . . . . . . . . . . . tanggal . . . . . . . . . . . . . . . yang dibuat dihadapan Rosida Sarjana Hukum. Notaris di Surabaya sebagai demikian sah mewakili dari dan oleh karena itu bertindak untuk dan atas nama PT. Bank Perkreditan Rakyat Jawa Timur berkedudukan di <b>Surabaya</b> selanjutnya disebut <b>“BANK”</b>.
                </td>
            </tr>
        </table>

        <br>

        <table class="table-perjanjian-2">
            <tr>
                <td style="width: 3%">1. </td>
                <td style="width: 20%">Nama</td>
                <td style="width: 1%">:</td>
                <td>{{ $dataNasabah->nama }}</td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">Alamat</td>
                <td style="width: 1%">:</td>
                @if ($dataUmum->skema_kredit == 'Dagulir')
                    <td>{{ $dataNasabah->alamat_ktp }}</td>
                @else
                    <td>{{ $dataNasabah->alamat_rumah }}</td>
                @endif
            </tr>
            {{-- <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">Pekerjaan</td>
                <td style="width: 1%">:</td>
                <td>{{ $dataNasabah->pekerjaan }}</td>
            </tr> --}}
            <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">No. KTP/SIM</td>
                <td style="width: 1%">:</td>
                @if ($dataUmum->skema_kredit == 'Dagulir')
                    <td>{{ $dataNasabah->nik }}</td>
                @else
                    <td>{{ $dataNasabah->no_ktp }}</td>
                @endif
            </tr>
        </table>

        <table class="table-perjanjian-3">
            <tr>
                <td style="width: 3%"></td>
                <td>
                    Bertindak untuk dan atas nama diri sendiri/perusahaan bersama-sama secara tanggung renteng melakukan tidakan hukum yang selanjutnya disebut <b>“Peminjam”</b>.
                    Bank dan “Peminjam” telah saling setuju dan sepakat membuat perjanjian kredit ini, dengan syarat-syarat dan ketentuan sebagai berikut :
                </td>
            </tr>
            {{-- <tr>
                <td></td>
                <td>Selanjutnya disebut <b>DEBITUR</b></td>
            </tr> --}}
        </table>

        {{-- <p>BANK dan DEBITUR telah saling setuju dan sepakat untuk membuat perjanjian ini, dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut :</p> --}}

        <table class="table-pasal-1">
            <tr>
                <td colspan="2" style="text-align: center"><b>Pasal 1</b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><b>KETENTUAN KREDIT DAN JANGKA WAKTU</b></td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">1. </td>
                <td>
                    Bank memberikan kepada “Peminjam” fasilitas kredit sejumlah Rp. {{ $dataUmum->skema_kredit == 'Dagulir' ? rupiah($dataNasabah->nominal) : rupiah($dataNasabah->jumlah_kredit) }} ({{ $dataUmum->skema_kredit == 'Dagulir' ? penyebut($dataNasabah->nominal) : penyebut($dataNasabah->jumlah_kredit)}}), yang dipergunakan untuk Modal Kerja
                    <b><i>{{$dataNasabah->tujuan_penggunaan}}</i></b> dengan jangka waktu {{ $dataUmum->skema_kredit == 'Dagulir' ? intval($dataNasabah->jangka_waktu) : intval($dataNasabah->tenor_yang_diminta) }} bulan terhitung sejak tanggal ....................
                    sampai dengan tanggal .................
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2. </td>
                <td>
                    Bank berhak untuk mengadakan peninjauan kembali secara berkala, menarik kembali/mengurangi jumlah fasilitas kredit yang telah disetujui sebagaimana tersebut dalam Pasal 1 Ayat 1 di atas apabila menurut pertimbangan Bank terdapat alasan-alasan yang penting untuk itu dan hal-hal diatas “Peminjam” tidak berhak untuk mengajukan klaim/gugatan/tuntutan apapun kepada Bank.
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>

        {{-- pasal 2 --}}
        <table class="table-pasal-2">
            <tr>
                <td colspan="2" style="text-align: center"><b>Pasal 2</b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><b>PENGAKUAN HUTANG</b></td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">1. </td>
                <td>
                    “Peminjam” dengan ini mengaku telah menerima dengan cukup fasilitas kredit tersebut dari Bank dan karenanya “Peminjam” mengaku telah berhutang dengan Bank sejumlah uang sebagaimana disebut dalam Pasal 1 Ayat 1 diatas belum termasuk bunga, provisi dan biaya-biaya, karena pemberian kredit tersebut serta denda yang mungkin timbul dikemudian hari. Selain perjanjian kredit ini maka sebagai  tanda penerima uang tersebut “Peminjam” akan menerbitkan tanda bukti penerimaan uang yang ditentukan oleh Bank.
                </td>
            </tr>
            <tr>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2.</td>
                <td>
                    Mengenai jumlah hutang “Peminjam” berdasarkan perjanjian ini oleh Bank dibuat catatan/administrasi dan catatan/administrasi tersebut merupakan bukti yang sah dan mengikat terhadap “Peminjam” mengenai jumlah uang yang terhutang dan wajib dibayar oleh “Peminjam” kepada Bank, baik berupa pokok, bunga, denda, maupun biaya-biaya lain yang mungkin timbul karena hutang tersebut demikian dengan tidak mengurangi hak peminjam untuk menerima kembali kelebihan pembayaran peminjam (jika ada) dan untuk kelebihan pembayaran tersebut Bank tidak diwajibkan membayar bunga/kerugian sesuatu apapun kepada peminjam.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">3. </td>
                <td>
                    “Peminjam” wajib membayar kembali hutangnya kepada Bank berdasarkan perjanjian ini sesuai jadwal angsuran terlampir atau perubahan-perubahannya yang merupakan satu-kesatuan serta bagian yang tidak terpisahkan dari penjajian ini, tanpa “Peminjam” berhak mempertimbangkan dengan tagihan “Peminjam” kepada Bank.
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
        </table>

        {{-- pasal 3 --}}
        <table class="table-pasal-3">
            <tr>
                <td colspan="2" style="text-align: center"><b>Pasal 3</b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><b>KEWAJIBAN DAN SANKSI</b></td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">1. </td>
                <td>
                    “Peminjam” membayar kepada Bank :
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a. </td>
                            <td>
                                Bunga sebesar …….% p.a. efektif rate pertahun dari fasilitas kredit tersebut dan harus dibayar tiap-tiap bulan sampai lunas
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b. </td>
                            <td>
                                Provisi sebesar 3%, biaya adminsitrasi sebesar 2%, dan biaya taksasi sebesar 1% dari plafond kredit dibayar “Peminjam” pada saat perjanjian ini ditanda-tangani
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">c. </td>
                            <td>
                                Biaya-biaya lain yang timbul dan yang akan timbul atas perjanjian kredit ini (antara lain biaya notaris, pemblokiran barang dan jaminan, asuransi)
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2. </td>
                <td>
                    Sistem angsuran kredit (bunga dan pokok) dibayar setiap bulan sampai dengan lunas.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">3.</td>
                <td>
                    Jika angsuran tidak dibayar pada waktu yang telah ditetapkan “Peminjam” wajib membayar denda dengan ketentuan-ketentuan sebagai berikut :
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a. </td>
                            <td>
                                Terhadap keterlambatan pembayaran angsuran melampaui jadwal angsuran dikenakan denda sebesar 10% (sepuluh persen) perbulan dari jumlah angsuran pokok dan bunga yang harus dibayar dan dihitung secara harian, lebih dari 3 (tiga) hari sesudah tanggal angsuran yang telah ditentukan pada setiap jadwal angsuran.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b. </td>
                            <td>
                                Terhadap kelambatan melunasi kredit dikenakan denda sebesar 50% (lima puluh persen) dari suku bunga yang berlaku atas sisa kredit yang bersangkutan.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">c. </td>
                            <td>
                                Tidak diperbolehkan meminjam untuk memfotokopi surat-surat jaminanya atau meminta surat keterangan untuk perpanjangan pajak kendaraan bermotor.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">d. </td>
                            <td>
                                Apabila telah berakhirnya perjanjian kredit, namun kredit tersebut belum lunas, maka perjanjian kredit tersebut tidak menghapuskan kewajiban debitur untuk melakukan pembayaran bunga, sehingga bunga tersebut tetap dapat ditagih oleh PT. Bank Perkreditan rakyat Jawa Timur pada debitur atas dasar perjanjian kredit awal.
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">4. </td>
                <td>
                    Apabila peminjam melunasi kredit sebelum jatuh tempo dan tidak mengambil kredit lagi, maka peminjam wajib membayar sisa pokok pinjaman dan dikenakan penalti dengan ketentuan sebagai berikut :
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a. </td>
                            <td>
                                Untuk pinjaman sudah berjalan kurang dari 50% jangka waktu kredit, peminjam dikenakan pinalti sebesar 5 (lima) kali bunga sesuai jadwal angsuran kredit.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b. </td>
                            <td>
                                Untuk pinjaman sudah berjalan lebih dari 50% jangka waktu kredit, peminjam dikenakan pinalti sebesar 3 (tiga) kali bunga sesuai jadwal angsuran kredit.
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">5. </td>
                <td>
                    Apabila peminjam melunasi kredit sebelum jatuh tempo dan mengambil kredit lagi, maka peminjam wajib membayar bunga sesuai jadwal angsuran pada saat pelunasan, sedangkan pokok dapat dikompensasi dengan pinjaman baru.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">6. </td>
                <td>
                    Bank berhak mengubah tingkat suku bunga kredit/denda yang terlebih dahulu melakukan pemberitahuan kepada peminjam 30 hari sebelumnya.
                </td>
            </tr>
        </table>

        {{-- <div class="page-break"></div> --}}

        {{-- pasal 4 --}}
        <table class="table-pasal-4">
            <tr>
                <td colspan="2" style="text-align: center"><b>Pasal 4</b></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center"><b>SANKSI ATAS PERISTIWA DILUAR PENGETAHUAN BANK</b></td>
            </tr>
            <tr>
                <td>
                    Dalam hal timbul/atau terjadi salah satu peristiwa yang disebut dibawah ini, yaitu :
                </td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                               “Peminjam” lalai memenuhi kewajibannya kepada Bank berdasarkan perjanjian kredit ini.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                “Peminjam” atau pihak yang memberikan jaminan ditaruh dibawah perwalian atau pengampunan atau karena sebab-sebab apapun juga tidak berhak lagi mengurus, mengelola atau menguasai harta bendanya.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3. </td>
                            <td>
                                “Peminjam” meninggal dunia, meninggalkan tempat tinggalnya/pergi ketempat yang tidak diketahui untuk waktu lama dan tidak tertentu, melakukan atau terlibat dalam suatu perbuatan/peristiwa yang menurut pertimbangan Bank dapat membahayakan pemberian kredit terdebut, ditangkap pihak berwajib atau dijatuhi hukuman penjara.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">4. </td>
                            <td>
                                Atas harta benda peminjam memberikan keterangan baik sebagian maupun seluruh yang dijaminkan atau yang tidak dijaminkan kepada Bank, diletakan sita jaminan (conservatoir beslag) atau sita eksekusi (executorial) oleh pihak ketiga.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">5. </td>
                            <td>
                                Nilai jaminan berkurang sedemikian rupa sehingga tidak lagi merupakan jaminan yang cukup atas seluruh dari hutang satu dan lain menurut pertimbangan dan penetapan Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">6. </td>
                            <td>
                                Kepada “Peminjam” memberi keterangan baik lisan atau tertulis yang tidak mempunyai kebenaran dalam arti materiil tentang keadaan kekayaan, penghasilan, barang jaminan dan segala keterangan dokumen yang diberikan kepada Bank sehubungan dengan hutang peminjam kepada Bank atau jika “Peminjam” menyerahkan tanda bukti penerimaan uang dan/atau surat pemindah bukuan yang ditandatangani oleh pihak-pihak yang tidak berwenang untuk menandatanganinya sehingga tanda bukti penerimaan uang atau surat pemindahbukuan tersebut tidak sah.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">7. </td>
                            <td>
                                “Peminjam” baik sebelum maupun sesudah kredit diberikan oleh Bank juga mempunyai hutang kepada pihak ketiga dan hal yang demikian tidak diberitahukan kepada Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">8. </td>
                            <td>
                                Kredit dipergunakan untuk tujuan lain dari maksud yang sebenarnya dari kredit yang diberikan.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">9. </td>
                            <td>
                                “Peminjam” lalai, melanggar atau tidak dapat/tidak memenuhi suatu ketentuan dalam perjanjian pemberian jaminan atau dokumen-dokumen lain sehubungan dengannya.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td>
                    Atau jika terjadi peristiwa apapun yang menurut pendapat Bank akan dapat mengakibatkan “Peminjam” tidak dapat memenuhi kewajiban-kewajiban kepada Bank, maka dengan mengesampingkan ketentuan dalam pasal 1267. Kitab Undang-Undang Hukum Perdata. Bank berhak untuk :
                </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Menghentikan perjanjian ini dan selanjutnya meminta “Peminjam” untuk membayar semua hutangnya kepada Bank berdasarkan perjanjian ini atau;
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Menjual harta benda yang dijaminkan oleh “Peminjam” kepada Bank baik dibawah tangan maupun di muka umum (secara umum) dengan harga dan syarat-syarat yang ditetapkan oleh Bank, dengan ketentuan pendapatan bersih dari penjualan tersebut dipergunakan untuk pembayaran seluruh hutang “Peminjam” kepada Bank dan bilamana ada sisa, maka sisa tersebut akan dikembalikan kepada “Peminjam” sebagai pemilik harta benda yang dijaminkan kepada Bank dan sebaliknya hasil penjualan tidak mencukupi untuk melunasi seluruh hutang “Peminjam” kepada Bank, maka kekurangan tersebut tetap menjadi hutang “Peminjam” kepada Bank dan wajib dibayar dengan seketika dan sekaligus lunas pada saat ditagih oleh Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3. </td>
                            <td>
                                Dalam rangka penyelesaian kewajiban “Peminjam”, Bank berhak memanggil “Peminjam” dan/atau mengumumkan nama “Peminjam” yang hutangnya bermasalah dan/atau pengumuman penjualan agunan dan segala keterangan yang berkaitan dengannya di media massa atau media lain yang ditentukan Bank dan atau melakukan perbuatan lain yang diperlukan, termasuk Tindakan memasuki tanah dan/atau pekarangan dan/atau bangunan yang menjadi agunan dan/atau lokasi dan memasang pengumuman pada agunan milik “Peminjam”, pengumuman mana tidak boleh diubah dan/atau dirusak oleh “Peminjam” sampai dengan kewajiban “Peminjam” lunas.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">4. </td>
                            <td>
                                Apabila debitur tidak melaksanakan kewajiban pembayaran sesuai jadwal angsuran sebagaimana perjanjian kredit ini dan telah dilakukan pemberian surat peringatan pertama sampai dengan peringatan ketiga, maka Bank berhak memasang sticker / papan yang bertuliskan bahwa “tanah dan / atau bangunan ini menjadi jaminan hutang dan dalam pengawasan di Bank BPR Jatim”, pada lokasi tanah/bangunan objek agunan dengan terlebih dahulu memberikan surat pemberitahuan atas rencana pemasangan tersebut.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>

        {{-- pasal 5 --}}
        <table class="table-pasal-5">
            <tr>
                <td colspan="3" style="text-align: center"><b>Pasal 5</b></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center"><b>JAMINAN KREDIT</b></td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">1. </td>
                <td colspan="2" style="text-align: justify;">
                    Untuk lebih menjamin pembayaran kembali dengan tertib dan sebagaimana mestinya hutang “Peminjam” kepada Bank  berdasarkan perjanjian ini, “Peminjam” dengan ini menyatakan telah memberikan dan menyerahkan hak milik secara kepercayaan (Fiduciare Eigendom Overdract)/ SKMHT/APHT yang dianggap cukup dan dapat diterima kepada Bank berupa :
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a. </td>
                            <td>
                                Jenis Kendaraan roda 2 / roda 4 :
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;"></td>
                            <td>
                                <table style="width: 100%; text-align: justify;">
                                    <tr>
                                        <td>Merek/Type</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                        <td>Tahun</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                    <tr>
                                        <td>No. BPKB</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                        <td>Atas Nama</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                    <tr>
                                        <td>No. Rangka</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                    <tr>
                                        <td>No. Mesin</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                    <tr>
                                        <td>No. Polis</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                    <tr>
                                        <td>Warna</td>
                                        <td>:</td>
                                        <td>..........................</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;"></td>
                            <td>
                                Dengan kewajiban bahwa “Peminjam” harus menyerahkan asli surat bukti kepemilikan yang sah kepada Bank.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b. </td>
                            <td>
                                Kuasa mendebet rekening tabungan/deposito nomor . . . . . . . .
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">c. </td>
                            <td>
                                Sebidang tanah dan bangunan/pekarangan/sawah SHM/SHGB nomor . . . . . . . . . Nama Pemilik . . . . . . . . . . Luas tanah . . . . . . . . . . Alamat Pemilik . . . . . . . . . . Alamat Jaminan . . . . . . . . . . Terletak di Desa/Kelurahan . . . . . . . . . . Kecamatan . . . . . . . . . . Kabupaten/Kota . . . . . . . . . . Propinsi . . . . . . . . . . Dengan batas-batas:
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td>
                    <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td>
                                <table style="width: 100%; text-align: justify;">
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>-</td>
                                        <td>Utara</td>
                                        <td>:</td>
                                        <td>. . . . . . . . .</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>-</td>
                                        <td>Timur</td>
                                        <td>:</td>
                                        <td>. . . . . . . . .</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>-</td>
                                        <td>Selatan</td>
                                        <td>:</td>
                                        <td>. . . . . . . . .</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>-</td>
                                        <td>Barat</td>
                                        <td>:</td>
                                        <td>. . . . . . . . .</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2. </td>
                <td style="text-align: justify;" colspan="2">Apabila menurut pendapat Bank nilai dari jaminan tidak lagi cukup untuk menjamin hutang “Peminjam” kepada Bank, maka atas permintaan pertama kali Bank, “Peminjam” wajib menambah jaminan lainnya yang disetujui oleh Bank.</td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">3. </td>
                <td style="text-align: justify;" colspan="2">Untuk kepentingan pelaksanaan ketentuan pasal ini, “Peminjam” memberikan kuasa penuh yang tidak dapat dicabut kembali kepada Bank untuk melakukan tindakan - tindakan yang dipandang perlu sesuai ketentuan peraturan perundang-undangan.</td>
            </tr>
        </table>

        <table class="table-pasal-6">
            <tr>
                <td colspan="3" style="text-align: center"><b>Pasal 6</b></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center"><b>WANPRESTASI & PENYELESAIAN KREDIT</b></td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">1. </td>
                <td style="text-align: justify;">
                    Bank berhak dengan seketika menagih pinjaman-nya dan “Peminjam” diwajibkan tanpa menunda-menunda lagi membayar seluruh pinjaman-nya berupa pokok, bunga, denda, biaya-biaya dan kewajiban lainnya yang mungkin timbul dengan seketika dan sekaligus lunas.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2. </td>
                <td style="text-align: justify;">
                    Bank akan melakukan penyelesaian pinjaman termasuk namun tidak terbatas pada upaya penjualan agunan baik secara di bawah tangan maupun melalui pelelangan umum, sell down, maupun melalui saluran hukum.
                </td>
            </tr>
        </table>

        <table class="table-pasal-7">
            <tr>
                <td colspan="3" style="text-align: center"><b>Pasal 7</b></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center"><b>SELL DOWN</b></td>
            </tr>
            <tr>
                <td>
                    Bank berhak dengan ketentuan dan syarat yang dianggap baik oleh Bank untuk :
                </td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a. </td>
                            <td>
                                Menjual atau mengalihkan dengan subrogasi, cessie atau cara lain sesuai peraturan perundang-undangan yang berlaku Sebagian atau seluruh pinjaman maupun hak Bank berdasarkan Perjanjian Kredit dan Pengakuan Hutang berikut dokumen agunan dan pengikatannya kepada pihak ketiga yang ditunjuk atau disetujui oleh Bank; dan/atau
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b. </td>
                            <td>
                                Melakukan sekuritisasi atas pinjaman kepada pihak ketiga.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-8">
            <tr>
                <td colspan="3" style="text-align: center"><b>Pasal 8</b></td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center"><b>DATA/INFORMASI PEMINJAM</b></td>
            </tr>
            <tr>
                <td>
                    “Peminjam” dengan Perjanjian Kredit dan Pengakuan Hutang ini memberikan Kuasa dan/atau Persetujuan kepada Bank untuk memberikan/melaporkan data dan/atau informasi “Peminjam”, termasuk tetapi tidak terbatas pada data/informasi tentang pinjaman dan simpanannya (deposito dan/atau tabungan) pada Bank kepada :
                </td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Bank Indonesia sesuai Peraturan Bank Indonesia Nomor 18/21/PBI/2016 tanggal 3 Oktober 2016 tentang Perubahan atas Peraturan Bank Indonesia Nomor 9/14/PBI/2007 tentang Sistem Informasi Debitur, berikut perubahannya.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Otoritas Jasa Keuangan sesuai Surat Edaran Otoritas Jasa Keuangan Nomor 50/SE.OJK.03/2017 tanggal 27 September 2017 tentang Pelaporan dan Permintaan Informasi Debitur Melalui sistem Layanan Informasi Keuangan, berikut perubahannya.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3. </td>
                            <td>
                                Pihak yang berwajib, termasuk namun tidak terbatas pada Kepolisian, Kejaksaan, Komisi Pemberantasan Korupsi, Perpajakan, yang penyerahannya dilakukan dengan berpedoman pada ketentuan perundang-undangan yang berlaku.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">4. </td>
                            <td>
                                Pihak Ketiga, termasuk namun tidak terbatas pada Lembaga penjaminan dan asuransi, konsultan, akuntan dan auditor, yang penyerahannya dilakukan dengan didasarkan pada perjanjian kerahasiaan.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>

        <table class="table-pasal-9">
            <tr>
                <td style="text-align: center"><b>Pasal 9</b></td>
            </tr>
            <tr>
                <td style="text-align: center"><b>ASURANSI</b></td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Bank dapat meminta penjaminan kredit kepada perusahaan penjaminan/asuransi yang ditunjuk oleh Bank sesuai dengan syarat dan ketentuan yang berlaku.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Sertifikat penjaminan disimpan di Bank sampai “Peminjam” melunasi pinjaman-nya.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3. </td>
                            <td>
                                Penjaminan sebagaimana ketentuan dalam Perjanjian Kredit dan Pengakuan Hutang ini dilakukan oleh Perusahaan Penjaminan/Asuransi Rekanan Bank sejumlah minimal sesuai dengan jumlah pinjamannya dengan mencantumkan Banker’s Clause dalam polisnya.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-10">
            <tr>
                <td style="text-align: center;"><b>Pasal 10</b></td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>LAPORAN DAN PEMERIKSAAN</b></td>
            </tr>
            <tr>
                <td>
                    Bank berhak untuk meminta laporan dan/atau melakukan pemeriksaan setiap waktu kepada “Peminjam” baik dilakukan oleh Bank maupun kuasanya yang ditunjuk oleh Bank terhadap pembukuan keuangan “Peminjam”/perusahaannya.
                </td>
            </tr>
        </table>

        <div class="page-break"></div>

        <table class="table-pasal-11">
            <tr>
                <td style="text-align: center;"><b>Pasal 11</b></td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>PEMBERIAN KUASA</b></td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1.</td>
                            <td>
                                Apabila Bank memandang perlu, maka dengan ini “Peminjam” memberi kuasa kepada Bank untuk memperjumpakan hutang “Peminjam” yang timbul karena Perjanjian Kredit dan Pengakuan Hutang ini maupun karena Perjanjian Kredit dan Pengakuan Hutang dan atau perjanjian lain untuk kepentingan/dengan Bank dengan piutang-piutang “Peminjam” yang ada pada Bank saat ini maupun yang akan datang, termasuk tetapi tidak terbatas pada deposito, tabungan dan/atau harta lain milik “Peminjam” yang ada pada Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2.</td>
                            <td>
                                Disamping kuasa-kuasa yang dalam Perjanjian Kredit dan Pengakuan Hutang ini secara tegas diberikan oleh “Peminjam” kepada Bank, maka untuk keperluan pelaksanaan Perjanjian Kredit dan Pengakuan Hutang, dengan ini “Peminjam” memberi kuasa kepada Bank untuk melaksanakan :
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;"></td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td style="vertical-align: top; width: 3%;">a. </td>
                                        <td>
                                            Pemblokiran, pembukaan blokir, pencairan dan/atau pendebetan sebagian atau seluruh rekening “Peminjam” pada Bank, baik pinjaman dan/atau simpanan berupa deposito dan/atau tabungan, dan/atau mengalihkan harta lain milik “Peminjam” yang ada pada pihak Bank saat ini maupun yang akan ada, untuk pembayaran/pelunasan kewajiban “Peminjam” kepada Bank.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top; width: 3%;">b. </td>
                                        <td>
                                            Penandatanganan kuitansi dan dokumen lainnya, menghadap kepada pejabat yang berwenang memberi keterangan serta melakukan Tindakan lainnya yang diperlukan yang berkaitan dengan pelaksanaan pemberian kuasa di atas.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3.</td>
                            <td>
                                Seluruh kuasa yang termaktub dalam Pasal ini maupun pasal lainnya dalam Perjanjian Kredit dan Pengakuan Hutang ini dapat disubtitusikan dan merupakan bagian yang terpenting dan tidak dapat dipisahkan dari Perjanjian Kredit dan Pengakuan Hutang ini. Oleh karena itu. Oleh karena itu, kuasa-kuasa tersebut tidak dapat ditarik Kembali dan/atau dibatalkan dengan cara apapun juga dan karena sebab-sebab yang dapat mengakhiri surat kuasa sebagaimana dimaksud dalam pasal 1813, 1814, dan 1816 Kitab Undang-Undang Hukum Perdata hingga seluruh kewajiban “Peminjam” dinyatakan lunas oleh Bank. Kuasa dimaksud telah diberikan dengan ditandatangani Perjanjian Kredit dan Pengakuan Hutang ini sehingga tidak diperlukan surat kuasa tersendiri.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-12">
            <tr>
                <td style="text-align: center;"><b>Pasal 12</b></td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>KETENTUAN-KETENTUAN LAIN</b></td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Kelalaian atau keterlambatan Bank untuk menggunakan hak atau kekuasaannya sesuai dengan Perjanjian Kredit dan Pengakuan Hutang tidak berarti sebagai waiver (pelepasan hak) kecuali hal tersebut dinyatakan secara tertulis oleh Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Semua perubahan, penambahan, pengurangan dan lampiran-lampiran dari Perjanjian Kredit dan Pengakuan Hutang ini yang dibuat dari waktu ke waktu merupakan satu kesatuan yang tidak dapat dipisahkan dari Perjanjian Kredit dan Pengakuan Hutang ini.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3. </td>
                            <td>
                                Segala sesuatu yang belum cukup diatur dalam Perjanjian Kredit dan Pengakuan Hutang ini yang oleh Bank diatur dalam surat menyurat maupun dibuatkan dengan dokumen/akta-akta lain, merupakan bagian yang tidak dapat dipisahkan dari Perjanjian Kredit dan Pengakuan Hutang.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">4. </td>
                            <td>
                                Apabila selain pinjaman ini, “Peminjam” memperoleh juga fasilitas pinjaman lainnya dari PT. Bank Pekreditan Rakyat Jawa Timur, maka antara pinjaman-pinjaman tersebut berlaku cross default, yaitu apabila salah satu pinjaman macet maka mengakibatkan pinjaman lainnya macet pula, sehingga PT. Bank Pekreditan Rakyat Jawa Timur mempunyai hak untuk mengeksekusi agunan-agunan yang telah diberikan pada masing-masing pinjaman.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">5. </td>
                            <td>
                                Adanya keadaan-keadaan di luar kekuasaan “Peminjam” tidak mengurangi kewajiban “Peminjam” untuk membayar pinjaman-nya kepada Bank dengan ini melepaskan Pasal 1245 dan 1245 Kitab Undang-Undang Hukum Perdata sepanjang hal tersebut melepaskan “Peminjam” dari membayar biaya, rugi, dan bunga karena terjadinya sesuatu hal yang tak diduga.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">6. </td>
                            <td>
                                Terhadap Perjanjian Kredit dan Pengakuan Hutang ini dan segala akibatnya berlaku pula “Syarat-Syarat Umum Perjanjian Kredit dan Pengakuan Hutang PT. Bank Pekreditan Rakyat Jawa Timur” yang telah disetujui oleh “Peminjam” dan mengikat “Peminjam” serta merupakan satu kesatuan yang tidak dapat dipisahkan dari Perjanjian Kredit dan Pengakuan Hutang ini.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-13">
            <tr>
                <td style="text-align: center;"><b>Pasal 13</b></td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>ATURAN HUKUM</b></td>
            </tr>
            <tr>
                <td>
                  <table style="width:100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Hal-hal yang belum diatur dalam perjanjian ini akan ditetapkan berdasarkan kesepakatan antara Bank dan “Peminjam” serta diatur secara tertulis dan merupakan satu bagian yang terpenting dan tidak dapat dipisahkan dengan perjanjian ini.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Perjanjian ini telah disesuaikan dengan ketentuan peraturan perundang – undangan termasuk ketentuan peraturan otoritas jasa keuangan.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>


        <table class="table-pasal-13">
            <tr>
                <td style="text-align: center;"><b>Pasal 14</b></td>
            </tr>
            <tr>
                <td style="text-align: center;"><b>KEDUDUKAN HUKUM</b></td>
            </tr>
            <tr>
                <td>
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1. </td>
                            <td>
                                Mengenai perjanjian ini dan segala akibat serta pelaksanaannya tempat kediaman yang sah dan tidak berubah di Kantor Kepaniteraan Pengadilan Negeri di ……………….. dan/atau KPKNL di ……………… demikian dengan tidak mengurangi hak dan wewenangnya Bank untuk menuntut pelaksanaan/eksekusi atau mengajukan tuntutan hukum terhadap “Peminjam” berdasarkan perjanjian ini melalui atau dihadapan Pengadilan-pengadilan lainnya dimanapun didalam wilayah Republik Indonesia.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2. </td>
                            <td>
                                Dengan ini DEBITUR menyatakan telah mengerti dan memahami isi Perjanjian ini termasuk seluruh hak dan kewajiban DEBITUR dan kondisi wanprestasi.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-13" style="text-align: justify;">
            <tr>
                <td>
                    Demikian perjanjian kredit dan pengakuan hutang ini dibuat untuk para pihak dalam rangkap 2 (dua) masing-masing sama bunyinya diatas kertas bermaterai cukup, serta mempunyai kekuatan hukum yang sama pada hari dan tanggal sebagaimana tersebut pada awal perjanjian ini dan berlaku sejak tanggal ditandatangani.
                </td>
            </tr>
        </table>

        <table class="table-ttd">
            <tr>
                <th style="font-weight: 500; width: 50%;"><b>PT. BPR Jawa Timur <br>Kantor Cabang {{ $dataCabang->cabang }}</b></th>
                <th style="font-weight: 500; width: 50%;"><b>DEBITUR</b></th>
            </tr>
            <tr>
                <td style="padding-top: 50px; padding-bottom: 50px;"></td>
                <td style="padding-top: 50px; padding-bottom: 50px; text-align: center; color: gainsboro">Meterai<br> Rp 10.000,-</td>
            </tr>
            <tr>
                <td style="text-align: center">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>({{ getKaryawan($dataPincab[0]['nip']) }})</td>
                            <td>({{ getKaryawan($dataPenyelia[0]['nip']) }})</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                Pemimpin Cabang
                            </td>
                            <td style="text-align: center;">
                                Penyelia Kredit
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="text-align: center">
                    <table style="width: 100%; text-align: center;">
                        <tr>
                            <td>({{$dataNasabah->nama}})</td>
                        </tr>
                        <tr>
                            <td>Debitur</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
