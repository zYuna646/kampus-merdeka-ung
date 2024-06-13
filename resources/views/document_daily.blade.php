<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <title>Document</title>
    Rancang Bangun Sistem Informasi Survei untuk Evaluasi Kinerja di Universitas Negeri Gorontalo Berbasis Web dengan
    Metode Waterfall


    maslaah :
    1. Kesulitan dalam Pemantauan Kinerja: Tidak adanya sistem yang terintegrasi dengan data evaluasi kinerja di
    Universitas Negeri Gorontalo menyebabkan proses evaluasi kinerja menjadi kurang efektif dalam mendukung pengambilan
    keputusan yang tepat.
    2. Pengelolaan Data yang Tidak Optimal: Data survei tidak dikelola dengan baik sehingga hasil dari survei kinerja
    masih dalam bentuk mentah dan sulit dibaca, menyulitkan pengambilan keputusan yang tepat.

    tujuan :
    1. Membangun Sistem Informasi yang Terintegrasi:
    Mengembangkan sistem informasi yang dapat terintegrasi dengan data pemantauan kinerja, dengan tujuan meningkatkan
    efektivitas dalam pemantauan kinerja di lingkungan Universitas Negeri Gorontalo.
    2. Mengoptimalkan Pengelolaan Data Survei:
    Mengembangkan sistem informasi yang mampu mengelola data survei dengan baik, sehingga hasil dari survei kinerja
    dapat tersedia dalam format yang terstruktur, mudah dibaca, dan dapat digunakan secara efektif untuk pengambilan
    keputusan yang tepat.

    manfaat :
    1. Peningkatan Efisiensi dan Efektivitas Pemantauan Kinerja: Dengan adanya sistem informasi yang terintegrasi dengan
    data pemantauan kinerja, proses pemantauan kinerja di Universitas Negeri Gorontalo dapat dilakukan secara lebih
    efisien dan efektif.
    2. Peningkatan Kualitas Pengambilan Keputusan:Dengan adanya sistem informasi yang mampu mengelola data survei
    kinerja dengan baik, hasil survei akan tersedia dalam format yang terstruktur dan mudah dibaca.

    metode penelitian kualitatif :
    menggunakan metode kualitatif untuk memahami kebutuhan, harapan, dan pengalaman pengguna terkait sistem survei yang
    dibangun, serta mengindentifikasi area area perbaikan yang diperlukan dalam pengembangan sistem.

    metode pengembangan sistem: waterfall

    tahapan penelitian :
    1. Studi Literatur : melakukan studi literatur tentang sistem informasi survei berbasis web
    2. pengumpulan data : pengumpulan data yang dibutuhkan dalam penelitian melalui observasi, wawancara, dan survey
    3. analisis kebutuhan sistem : Mengidentifikasi fungsionalitas utama yang dibutuhkan dalam sistem survei kinerja,
    seperti pembuatan dan distribusi survei, pengumpulan dan penyimpanan data survei, serta analisis dan pelaporan hasil
    survei.
    4. perancangan dan desain sistem : merancang alur kerja sistem, struktur basis data, dan tampilan sistem berdasarkan
    kebutuhan yang telah ditentukan
    5. implementasi : mengimplementasikan hasil desain yang telah dibuat berdasarkan fungsionalitas yang diperlukan
    6. pengujian : melakukan pengujian fungsionalitas, pengujian integrasi dan pengujian keseluruhan dari sistem yang
    telah dibuat.


    referensi 1
    judul : Rancang Bangun Sistem Informasi Survei Kepuasan Mahasiswa pada STIKes Getsempena Lhoksukon
    penulis : ulfa nadia, faisal
    jurnal : Journal of Informatics, Information System, and Artificial Intelligence Volume 2, Nomor 1, Mei 2024

    keterkaitan : penilitian ini memiliki tujuan rancang bangun sistem informasi survey

    referensi 2 :
    judul : RANCANG BANGUN SISTEM INFORMASI SOFTWARE POINT OF SALE(POS) DENGAN METODE WATERFALL BERBASIS WEB
    penulis : Putu Gede Surya Cipta Nugraha, Ni Wayan Wardani, Wayan Sukarmayasa
    jurnal : Jurnal Sains dan Teknologi Vol.10No 1 Tahun 2021

    keterkaitan : penelitian ini memiliki tujuan rancang bangun sistem informasi menggunakan metode waterfall

    referensi 3 :
    judul : RANCANG BANGUN SISTEM INFORMASI SURAT MASUK DAN SURAT
    KELUAR BERBASIS WEB MENGGUNAKAN METODE WATERFALL
    penulis : Riswandi Ishak, Setiaji, Fajar Akbar, dan Mahmud Safudin
    jurnal : Jurnal Indonesia Sosial Teknologi Vol. 1, No. 3 Oktober 2020

    keterkaitan : penilitian ini memiliki tujuan rancang bangun sistem informasi menggunakan metode waterfall


    <style>
        p {
            margin: 4px;
        }

        body {
            padding: 3rem;
        }

        header {
            width: 100%;
            display: flex;
            flex-direction: column;
            row-gap: 0.5rem
        }

        div.title {
            width: 100%;
            align-items: center;
            display: flex;
            flex-direction: column;
            font-weight: 700;
        }

        div.bio {
            font-weight: 600;
            display: flex;
            flex-direction: column;
            margin-top: 1rem
                /* 16px */
            ;
        }

        main {
            display: flex;
            align-items: flex-start;
            width: 100%;
            margin-top: 1rem
                /* 16px */
            ;
        }

        main table {
            width: 100%;
            border-collapse: collapse;
            border-width: 1px;
        }

        main table thead tr th {
            border-width: 1px;
            padding: 1rem
                /* 16px */
            ;
        }

        main table tbody tr td {
            border-width: 1px;
            padding: 1rem
                /* 16px */
            ;
        }

        footer {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 2rem
                /* 32px */
            ;
            padding-left: 1rem
                /* 16px */
            ;
            padding-right: 1rem
                /* 16px */
            ;
        }

        div.sign {
            display: flex;
            flex-direction: column;
            font-weight: 600;
            max-width: 32rem
                /* 512px */
            ;
            align-items: center;
        }

        div.name {
            width: 5rem
                /* 80px */
            ;
            height: 5rem
                /* 80px */
            ;
        }
    </style>
</head>
@php
use Carbon\Carbon;
$dateFormatted = Carbon::parse($daily->date)
->locale('id')
->isoFormat('dddd, D MMMM YYYY');
@endphp

<body class="p-12">
    <header class="w-full flex flex-col gap-y-2">
        <div class="w-full items-center flex flex-col font-bold ">
            <p>FORMAT LOG BOOK HARIAN</p>
            <p>KEGIATAN {{ $program->name }}</p>
        </div>
        <div class="font-semibold flex flex-col mt-4">
            <p>Nama Mahasiswa : {{ $mahasiswa->name }}</p>
            <p>Jurusan : Teknik {{ $jurusan->name }}</p>
            <p>Nama Sekolah : {{ $lokasi->name }}</p>
            <p>Hari/Tanggal : {{ $dateFormatted }}</p>
        </div>
    </header>
    <main class="flex items-start w-full mt-4">
        <table class="w-full border-collapse border" border="1">
            <thead>
                <tr>
                    <th class="border p-4">No</th>
                    <th class="border p-4">Mulai aktivitas</th>
                    <th class="border p-4">Deskripsi aktivitas</th>
                    <th class="border p-4">Rencana kegiatan ke-</th>
                    <th class="border p-4">% Capaian dari rencana</th>
                    <th class="border p-4">Hambatan</th>
                    <th class="border p-4">Rencana solusi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity as $index => $item)
                @php
                $jamMulai = Carbon::parse($item->jam_mulai)->format('H:i');
                $jamSelesai = Carbon::parse($item->jam_selesai)->format('H:i');
                @endphp
                <tr>
                    <td class="border p-4">{{ $index }}</td>
                    <td class="border p-4">{{ $jamMulai }} - {{ $jamSelesai }}</td>

                    <td class="border p-4">{{$item->desc}}</td>
                    <td class="border p-4">{{$item->rencana}}</td>
                    <td class="border p-4">{{$item->presentase . '%'}}</td>
                    <td class="border p-4">{{$item->hambatan}}</td>
                    <td class="border p-4">{{$item->solusi}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </main>
    <footer class="w-full flex justify-between items-end mt-8 px-4">
        <div class="flex flex-col font-semibold max-w-lg items-center">
            <p class="">Mengetahui</p>
            <p>Guru Pamong</p>
            <div class="w-20 h-20"></div>
            <p>({{$pamong->guru->name}})</p>
        </div>
        <div class="flex flex-col font-semibold max-w-lg items-center">
            <p>Mahasiswa Peserta</p>
            <div class="w-20 h-20"></div>
            <p>({{$mahasiswa->name}})</p>
        </div>
    </footer>
</body>

</html>