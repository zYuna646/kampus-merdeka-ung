<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
</head>

<body class="p-12">
    <header class="w-full flex flex-col gap-y-2">
        <div class="w-full items-center flex flex-col font-bold ">
            <p>FORMAT LOG MINGGUAN</p>
            <p>KEGIATAN {{ $data->programTransaction->lowongan->program->name }}</p>
        </div>
        @php
            use Carbon\Carbon;
            $dateFormatted = Carbon::parse($data->date)
                ->locale('id')
                ->isoFormat('dddd, D MMMM YYYY');
        @endphp

        <div class="font-semibold flex flex-col mt-4">
            <p>Nama Mahasiswa : {{ $data->programTransaction->mahasiswa->name }}</p>
            <p>Jurusan : {{ $data->programTransaction->mahasiswa->studi->jurusan->name }}</p>
            <p>Lokasi : {{ $data->programTransaction->lokasi->name }}</p>
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
                @foreach ($data->activity as $index => $item)
                    <tr>
                        <td class="border p-4">{{ $index }}</td>
                        @php
                            $jamMulai = Carbon::parse($item->jam_mulai)->format('H:i');
                            $jamSelesai = Carbon::parse($item->jam_selesai)->format('H:i');
                        @endphp
                        <td class="border p-4">{{ $jamMulai }} - {{ $jamSelesai }}</td>
                        <td class="border p-4">{{ $item->desc }}</td>
                        <td class="border p-4">{{ $item->rencana }}</td>
                        <td class="border p-4">{{ $item->presentase . '%' }}</td>
                        <td class="border p-4">{{ $item->hambatan }}</td>
                        <td class="border p-4">{{ $item->solusi }}</td>
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
            <p>({{$data->programTransaction->pamong}})</p>
        </div>
        <div class="flex flex-col font-semibold max-w-lg items-center">
            <p>Mahasiswa Peserta</p>
            <div class="w-20 h-20"></div>
            <p>({{$data->programTransaction->dpl}})</p>
        </div>
    </footer>
</body>

</html>
