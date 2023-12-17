<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Perjanjian Kredit</title>
    <style>
        body{
            font-size: 20px;
            width: 215mm;
            height: 330mm;
        }
        .heading {
            text-align: center;
        }

        .no-surat {
            margin-top: -17px;
        }

        .table-perjanjian,
        .table-perjanjian-2,
        .table-perjanjian-3 {
            width: 100%;
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
            width: 100%;
        }

        .table-ttd {
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
@endphp
<body onload="printPage()">
    <div class="data-surat">
        <div class="heading">
            <h3>PERJANJIAN KREDIT</h3>
            <p class="no-surat">Nomor : ................................</p>
        </div>

        <p>Perjanjian ini dibuat pada hari ini, ..................... tanggal ............................ oleh dan antara :</p>

        <table class="table-perjanjian">
            <tr>
                <td style="vertical-align: top; width: 3%">I.</td>
                <td style="text-align: justify">PT. Bank Perkreditan Rakyat Jawa Timur berkedudukan di Surabaya, dalam hal ini melalui Cabangnya di ...........................
                    beralamat di ............................ yang diwakili oleh ..............................., masing-masing selaku Pemimpin Cabang dan Penyelia Kredit;
                    dalam hal ini bertindak dalam jabatannya tersebut dan berdasarkan Surat Keputusan Nomor: ........................... dan Akta Kuasa Nomor ...............,
                    tanggal .............................. yang dibuat dihadapan Rosida, Sarjana Hukum, Notaris di Surabaya.
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Selanjutnya disebut <b>BANK</b></td>
            </tr>
        </table>

        <br>

        <table class="table-perjanjian-2">
            <tr>
                <td style="width: 3%">II.</td>
                <td style="width: 20%">Nama</td>
                <td style="width: 1%">:</td>
                <td>{{ $dataNasabah->nama }}</td>
            </tr>
            <tr>
                <td style="width: 3%"></td>
                <td style="width: 20%">Alamat</td>
                <td style="width: 1%">:</td>
                <td>{{ $dataNasabah->alamat_ktp }}</td>
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
                <td>{{ $dataNasabah->nik }}</td>
            </tr>
        </table>

        <table class="table-perjanjian-3">
            <tr>
                <td style="width: 3%"></td>
                <td style="text-align: justify">
                    Dalam hal ini bertindak untuk diri sendiri dan untuk melakukan tindakan hukum tersebut dalam perjanjian ini telah memperoleh
                    persetujuan dari suami/istri, yaitu ............................. yang turut menandatangani perjanjian ini/sebagaimana ternyata
                    dalam suratnya tanggal .....................
                </td>
            </tr>
            <tr>
                <td></td>
                <td>Selanjutnya disebut <b>DEBITUR</b></td>
            </tr>
        </table>

        <p style="text-align: justify">BANK dan DEBITUR telah saling setuju dan sepakat untuk membuat perjanjian ini, dengan syarat-syarat dan ketentuan-ketentuan sebagai berikut :</p>

        <table class="table-pasal-1">
            <p style="text-align: center"><b>Pasal 1</b></p>
            <tr>
                <td style="vertical-align: top; width: 3%;">1.</td>
                <td style="text-align: justify">
                    BANK memberikan kepada DEBITUR fasilitas kredit sampai sejumlah Rp. {{ rupiah($dataNasabah->nominal) }} (...terbilang...), yang dipergunakan untuk
                    <b><i>konsumsi (Pembelian Kendaraan Bermotor)</i></b> untuk jangka waktu {{ intval($dataNasabah->jangka_waktu) }} (.................) bulan terhitung sejak tanggal ....................
                    sampai dengan tanggal .................
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2.</td>
                <td style="text-align: justify">
                    DEBITUR dengan ini mengaku telah menerima dengan cukup fasilitas kredit tersebut dari BANK dan karenanya DEBITUR mengaku telah berhutang kepada Bank
                    sejumlah uang sebagaimana tersebut dalam pasal 1 ayat 1 di atas belum termasuk bunga, provisi dan biaya-biaya karena pemberian kredit tersebut
                    serta denda yang mungkin timbul dikemudian hari. Selain perjanjian ini, maka sebagai tanda penerimaan uang tersebut DEBITUR akan menerbitkan tanda bukti
                    penerimaan uang yang ditentukan oleh BANK.
                </td>
            </tr>
        </table>

        <table class="table-pasal-2">
            <p style="text-align: center"><b>Pasal 2</b></p>
            <tr>
                <td style="vertical-align: top; width: 3%;">1.</td>
                <td style="text-align: justify">
                    DEBITUR harus membayar pada BANK :
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;"></td>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a)</td>
                            <td>
                                Bunga sebesar ..........% p.a (anuitas/flat/efektif) floating rate pertahun dari fasilitas kredit tersebut dan harus dibayar tiap-tiap bulan sesuai dengan jadwal angsuran.
                                Bank berhak mengubah tingkat suku bunga, dengan pemberitahuan 30 hari sebelumnya kepada Debitur.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b)</td>
                            <td>
                                Biaya Provisi ..........% dari plafond kredit dipungut pada saat penandatanganan kredit.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">c)</td>
                            <td>
                                Biaya administrasi ..........% dari plafond kredit dipungut pada saat penandatanganan kredit.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">d)</td>
                            <td>
                                Biaya meterai kredit sesuai dengan ketentuan Bea Meterai.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2.</td>
                <td style="text-align: justify">
                    Untuk menjamin DEBITUR maka DEBITUR diwajibkan menutup asuransi secara Life Credit Insurance yang dilengkapi dengan P.A Plus PHK atau Life Credit Insurance PA Plus PHK.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">3.</td>
                <td style="text-align: justify">
                    Debitur diwajibkan membuka rekening tabungan sebesar setoran awal sebagaimana ketentuan pembukaan tabungan SIKEMAS dan sebesar 1 (satu) kali angsuran,
                    selanjutnya DEBITUR dengan ini memberikan kuasa kepada BANK untuk mendebet rekening tabungan nomor ..................... guna keprluan angsuran kredit dan pembayaran pelunasan kendaraan.
                </td>
            </tr>
        </table>

        <table class="table-pasal-3">
            <p style="text-align: center"><b>Pasal 3</b></p>
            <tr>
                <td style="vertical-align: top; width: 3%;">1.</td>
                <td style="text-align: justify">
                    Kredit sebesar yang ditentukan dalam pasal 1 ayat 1 tersebut harus dibayar lunas dalam waktu {{ intval($dataNasabah->jangka_waktu) }} (................) bulan dan diangsur dalam ................. (.................)
                    kali angsuran, setiap 1 (satu) bulan sekali seperti ditentukan dalam lampiran yang merupakan satu kesatuan dengan perjanjian ini.
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top; width: 3%;">2.</td>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">a.</td>
                            <td>
                               Terhadap keterlambatan membayar angsuran hutang/kredit lebih dari 7 (tujuh) hari sesudah tanggal angsuran yang telah ditentukan dikenakan denda 1% (satu) persen perbulan
                               dihitung secara harian dari jumlah angsuran pokok dan bunga yang harus dibayar. Bank berhak mengubah prosentase denda, dengan pemberitahuan 30 hari sebelumnya kepada Debitur.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">b.</td>
                            <td>
                                Terhadap keterlambatan melunasi hutang/kredit, maka BANK berhak memperhitungkan denda (penalty overdue) sebesar 50% dari suku bunga yang berlaku atas sisa kredit yang bersangkutan.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-4">
            <p style="text-align: center"><b>Pasal 4</b></p>
            <tr>
                <td style="text-align: justify">
                    Semua pembayaran angsuran oleh DEBITUR harus dilakukan di kantor PT. BPR Jatim atau kuasanya di ............., bebas dari hak memperhitungkan tagihan (Schuldvergelijking) dan biaya apapun juga,
                    atas pemberian kwitansi yang ditandatangani oleh PT. BPR Jatim atau kuasanya.
                </td>
            </tr>
        </table>

        <table class="table-pasal-5">
            <p style="text-align: center"><b>Pasal 5</b></p>
            <tr>
                <td style="text-align: justify">
                    Bilamana pelunasan kredit tersebut beserta bunganya tidak dilakukan pada waktunya, dengan cara dan tempat seperti yang ditentukan dalam perjanjian kredit ini, maka karena itu saja sudah cukup bukti
                    tentang adanya pelanggaran atau kealpaan DEBITUR tanpa diperlukan lagi pemberitahuan dengan surat juru sita dan lain surat semacam itu.
                </td>
            </tr>
        </table>

        <table class="table-pasal-6">
            <p style="text-align: center"><b>Pasal 6</b></p>
            <tr>
                <td style="text-align: justify">
                    Kredit tersebut dengan segera serta sekaligus dapat ditagih oleh BANK:
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1.</td>
                            <td>
                                Bilamana DEBITUR tidak menjalankan dengan betul perjanjian-perjanjian atau salah satu perjanjian tersebut dalam pernjajian kredit ini.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2.</td>
                            <td>
                                Bilamana atas barang tersebut di bawah ini dan atas milik yang mengambil kredit dikenakan sitaan executorial atau bilamana suatu sitaan
                                sementara yang ditaruh atas milik-milik itu dinyatakan sah dan berharga.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3.</td>
                            <td>
                                Bilamana DEBITUR minta penundaan pembayaran (Surseance Van Betaling), ditaruh di bawah pengampuan, meninggal dunia, atau tidak mengatur
                                harta bendanya dan milik-miliknya ataupun karena sebab apapun juga kehilangan hak untuk menguasai harta bendanya.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">4.</td>
                            <td>
                                Bilamana DEBITUR dipindahtugaskan ke daerah lain dan atau menjalani pensiun/purna tugas, dan DEBITUR menyatakan sanggup untuk melunasi dengan seketika dan sekaligus.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <br><br>
        <table class="table-pasal-7">
            <p style="text-align: center"><b>Pasal 7</b></p>
            <tr>
                <td style="text-align: justify">
                    Segala biaya yang bersangkutan dengan penagihan hutang tersebut baik di luar maupun di muka pengadilan, termasuk juga pengacara atau kuasa BANK yang diserahi penagihan itu
                    menjadi tanggungan dan harus dibayar oleh DEBITUR, sedangkan bilamana penagihan tersebut dilakukan di muka pengadilan dengan perantara atau kuasa BANK, maka DEBITUR wajib
                    menanggung dan segera harus membayar sekaligus seluruh biaya penagihan hutang sebesar 100% (seratus persen) dari jumlah penagihan yang harus dibayar.
                </td>
            </tr>
        </table>

        <table class="table-pasal-8">
            <p style="text-align: center"><b>Pasal 8</b></p>
            <tr>
                <td style="text-align: justify">
                    Sebagai tanggungan supaya hutang/kredit terbayar dengan baik guna kepentingan BANK, DEBITUR harus:
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1.</td>
                            <td>
                                Memberi kuasa dengan hak subtitusi yang tidak dapat dicabut kembali kepada BANK untuk memperhitungkan langsung penerimaan gaji setiap bulannya
                                sebagai angsuran pinjaman hingga lunas.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2.</td>
                            <td>
                                Memberi pernyataan bahwa gaji DEBITUR tidak dapat dipindahkan ke Bendahara gaji lainnya sebelum kredit tersebut lunas, kecuali ada persetujuan dari Bank.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">3.</td>
                            <td>
                                Memberi dan mengikat secara warborg hypotik, cessie, atau dalam pemilikan fiduciare sampai jumlah setinggi-tingginya Rp. ................. ditambah dengan
                                biaya realisasi, bunga, denda yang timbul akibat perjanjian ini atas:
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;"></td>
                            <td>
                                <table style="width: 100%">
                                    <tr>
                                        <td style="width: 15%">Nomor BPKB</td>
                                        <td style="width: 1%">:</td>
                                        <td>..............................</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Tanggal</td>
                                        <td style="width: 1%">:</td>
                                        <td>..............................</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Nama</td>
                                        <td style="width: 1%">:</td>
                                        <td>..............................</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">
                    Dan dengan ini DEBITUR memberi kuasa mutlak kepada BANK yang tidak dapat dicabut kembali karena alasan apapun, dengan hak memindahkan kuasa ini dengan sebagian
                    atau sepenuhnya kepada pihak lain untuk menaruh dalam pemilikan fiduciare/memasang hak tangungan baik secara notariil ataupun langsung kepada kantor pendaftaran
                    tanah dan seluruh biaya ditanggung oleh pihak DEBITUR.
                </td>
            </tr>
        </table>

        <table class="table-pasal-9">
            <p style="text-align: center"><b>Pasal 9</b></p>
            <tr>
                <td style="text-align: justify">
                    Untuk menambah kekuatan atas tanggungan dalam pasal 8 di atas, DEBITUR dapat:
                </td>
            </tr>
            <tr>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1.</td>
                            <td>
                                Memberi kuasa mutlak yang tak dapat dicabut kembali karena alasan apapun kepada BANK dengan hak untuk memindahkan kuasa ini sepenuhnya
                                kepada orang lain (subtitusi) untuk menjual di muka umum maupun di bawah tangan.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-10">
            <p style="text-align: center"><b>Pasal 10</b></p>
            <tr>
                <td style="text-align: justify">
                    Bank berkewajiban mengembalikan jaminan/tanggungan hutang yang diberikan oleh DEBITUR apabila hutang tersebut sudah dibayar lunas.
                </td>
            </tr>
        </table>

        <table class="table-pasal-11">
            <p style="text-align: center"><b>Pasal 11</b></p>
            <tr>
                <td style="text-align: justify">
                  <table style="width: 100%; text-align: justify;">
                        <tr>
                            <td style="vertical-align: top; width: 3%;">1.</td>
                            <td>
                                Ha-hal yang belum diatur dalam perjanjian ini akan ditetapkan berdasarkan kesepakatan antara Bank dan "Debitur" serta diatur secara tertulis
                                dan merupakan satu bagian yang terpenting dan tidak dapat dipisahkan dengan perjanjian ini.
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; width: 3%;">2.</td>
                            <td>
                                Perjanjian ini telah disesuaikan dengan ketentuan peraturan perundangan - undangan termasuk ketentuan peraturan otoritas jasa keuangan.
                            </td>
                        </tr>
                  </table>
                </td>
            </tr>
        </table>

        <table class="table-pasal-12">
            <p style="text-align: center"><b>Pasal 12</b></p>
            <tr>
                <td style="text-align: justify">
                    Baik BANK maupun DEBITUR telah memilih tempat tinggal yang umum dan tetap tentang segala hal yang timbul akibat dari surat perjanjian kredit ini di kantor
                    Panitera Pengadilan Negeri ....................... atau lembaga lainnya yang berwenang.
                </td>
            </tr>
        </table>

        <table class="table-pasal-13">
            <p style="text-align: center"><b>Pasal 13</b></p>
            <tr>
                <td style="text-align: justify">
                    Demikian perjanjian ini dibuat di ................. dalam rangkap 2 (dua), masing-masing sama bunyinya diatas kertas bermeterai cukup serta
                    mempunyai kekuatan hukum yang sama pada hari dan tanggal tersebut di atas dan setelah dibaca dan dimengerti isinya, lalu di tandatangani oleh para pihak.
                </td>
            </tr>
        </table>

        <table class="table-ttd">
            <tr>
                <th style="font-weight: 500; width: 50%;"><b>PT. Bank Perkreditan Rakyat Jawa Timur <br>Cabang {{ $dataCabang->cabang }}</b></th>
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
                            <td>(.....................................)</td>
                            <td>(.....................................)</td>
                        </tr>
                    </table>
                </td>
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
                doc.save('Surat Perjanjian Kredit.pdf');
            }
        });
    }
</script>
</html>
