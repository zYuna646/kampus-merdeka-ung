<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
    <title>Document</title>


    <style>
        p {
            margin: 4px;
        }

        body {
            /* padding: 3rem; */
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
            margin-top: 2rem;
            display: table;
        }

        div.sign {
            display: table-cell;
            font-weight: 600;
            width: 50%;
            text-align: center;
        }

        div.name {
            width: 5rem;
            height: 5rem;
        }
    </style>
</head>
@php
use Carbon\Carbon;
$dateFormatted = Carbon::parse($daily->date)
->locale('id')
->isoFormat('dddd, D MMMM YYYY');
@endphp

<body class="" style="padding: 1rem">
    <header style="width: 100%; display: flex; flex-direction: column; row-gap: 0.5rem;">
        <div style=" width: 100%; font-weight: 700; text-align: center;">
            <p>FORMAT LOG BOOK MINGGUAN</p>
            <p>KEGIATAN {{ $program->name }}</p>
        </div>
        <div style=" font-weight: 600; display: flex; flex-direction: column; margin-top: 1rem;">
            <p>Nama Mahasiswa : {{ $mahasiswa->name }}</p>
            <p>Jurusan : Teknik {{ $jurusan->name }}</p>
            <p>Nama Sekolah : {{ $lokasi->name }}</p>
            <p>Hari/Tanggal : {{ $dateFormatted }}</p>
        </div>
    </header>
    <main style=" display: flex; align-items: flex-start; width: 100%; margin-top: 1rem;">
        <table border="1" style=" width: 100%; border-collapse: collapse; border-width: 1px;">
            <thead>
                <tr>
                    <th style=" border-width: 1px; padding: 1rem">No</th>
                    <th style=" border-width: 1px; padding: 1rem">Mulai aktivitas</th>
                    <th style=" border-width: 1px; padding: 1rem">Deskripsi aktivitas</th>
                    <th style=" border-width: 1px; padding: 1rem">Rencana kegiatan ke-</th>
                    <th style=" border-width: 1px; padding: 1rem">% Capaian dari rencana</th>
                    <th style=" border-width: 1px; padding: 1rem">Hambatan</th>
                    <th style=" border-width: 1px; padding: 1rem">Rencana solusi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activity as $index => $item)
                @php
                $jamMulai = Carbon::parse($item->jam_mulai)->format('H:i');
                $jamSelesai = Carbon::parse($item->jam_selesai)->format('H:i');
                @endphp
                <tr>
                    <td style=" border-width: 1px;padding: 1rem">{{ $index }}</td>
                    <td style=" border-width: 1px;padding: 1rem">{{ $jamMulai }} - {{ $jamSelesai }}</td>

                    <td style=" border-width: 1px;padding: 1rem">{{$item->desc}}</td>
                    <td style=" border-width: 1px;padding: 1rem">{{$item->rencana}}</td>
                    <td style=" border-width: 1px;padding: 1rem">{{$item->presentase . '%'}}</td>
                    <td style=" border-width: 1px;padding: 1rem">{{$item->hambatan}}</td>
                    <td style=" border-width: 1px;padding: 1rem">{{$item->solusi}}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </main>
    <footer>
        <div class="sign">
            <p>Mengetahui</p>
            <p>Dosen Penangung Jawab Lapangan</p>
            <div class="name"></div>
            <p>({{ $dpl->dosen->name }})</p>
        </div>
        <div class="sign">
            <p style="margin-top: 20px">Mahasiswa Peserta</p>
            <div class="name"></div>
            <p>({{ $mahasiswa->name }})</p>
        </div>
    </footer>
</body>

</html>