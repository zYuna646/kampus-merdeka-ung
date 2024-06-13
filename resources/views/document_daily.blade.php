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
        <div class="title w-full items-center flex flex-col font-bold ">
            <p>FORMAT LOG BOOK HARIAN</p>
            <p>KEGIATAN {{ $program->name }}</p>
        </div>
        <div class="bio font-semibold flex flex-col mt-4">
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
        <div class="sign flex flex-col font-semibold max-w-lg items-center">
            <p class="">Mengetahui</p>
            <p>Guru Pamong</p>
            <div class="name w-20 h-20"></div>
            <p>({{$pamong->guru->name}})</p>
        </div>
        <div class="flex flex-col font-semibold max-w-lg items-center">
            <p>Mahasiswa Peserta</p>
            <div class="name w-20 h-20"></div>
            <p>({{$mahasiswa->name}})</p>
        </div>
    </footer>
</body>

</html>