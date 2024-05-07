<div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="col-span-2">
            <img src="/images/avatar/avatar.jpg" alt="" class="w-20 rounded-full">
        </div>
        <div class="col-span-12 mt-4">
            <h4 class="font-semibold text-lg">{{ $peserta->mahasiswa->name }} ({{ $peserta->mahasiswa->nim }})</h4>
        </div>

        <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">{{ $peserta->lowongan->program->name }}</p>
        </div>
        <div class="col-span-12 mt-4 flex flex-col gap-y-2">
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">NIM: </span>
                <p class="text-sm">{{ $peserta->mahasiswa->nim }}</p>
            </div>
            <div class="flex flex-col">
                <span class="text-xs text-slate-500">Periode Kegiatan: </span>
                <p class="text-sm">{{ \Carbon\Carbon::parse($peserta->lowongan->tanggal_mulai)->format('d M Y') }} -
                    {{ \Carbon\Carbon::parse($peserta->lowongan->tanggal_selesai)->format('d M Y') }} </p>
            </div>

        </div>

    </div>
    <div class="flex flex-col gap-y-2 max-h-[42rem] overflow-y-auto">

        @foreach ($peserta->weeklyLog as $index => $item)
            @php
                $statusColor = '';
                $statusIcon = '';
                switch ($item->status) {
                    case 'terima':
                        $statusColor = 'success';
                        $statusIcon = 'check-circle';
                        break;
                    case 'proses':
                        $statusColor = 'warning';
                        $statusIcon = 'spinner';
                        break;
                    case 'tolak':
                        $statusColor = 'danger';
                        $statusIcon = 'times-circle';
                        break;
                    case 'belum':
                        $statusColor = 'gray';
                        $statusIcon = 'clock';
                        break;
                    default:
                        $statusColor = 'primary';
                        $statusIcon = 'exclamation-circle';
                        break;
                }
            @endphp
            <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="flex gap-x-6 w-full col-span-12">
                    <span
                        class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-{{ $statusColor }}-500 bg-{{ $statusColor }}-100 border border-{{ $statusColor }}-500 rounded-full">
                        <i class="fas fa-{{ $statusIcon }} text-lg"></i>
                    </span>
                    <div class="flex flex-col gap-y-2">
                        <h4 class="text-xl font-semibold">Log Book Minggu Ke-{{ $index + 1 }}</h4>
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('dddd D MMMM YYYY') }} -
                            {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('dddd D MMMM YYYY') }}</p>
                        <a href="{{ route('guru.daily.log', ['id' => $item->id]) }}"
                            class="text-white h-fit w-fit bg-gray-500 hover:bg-{{ $statusColor }}-600 focus:ring-4 focus:ring-{{ $statusColor }}-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                            Periksa Laporan
                        </a>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
</div>
