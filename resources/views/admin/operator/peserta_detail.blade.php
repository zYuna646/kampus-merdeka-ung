<div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="col-span-2">
            <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full">
        </div>
        <div class="col-span-12 mt-4">
            <h4 class="font-semibold text-lg">{{ $peserta->mahasiswa->name }} ({{ $peserta->mahasiswa->nim }})</h4>
        </div>
        <div class="col-span-12 mt-4">
            <h4 class="font-semibold text-lg">{{ $peserta->lokasi->name }}</h4>
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
        @if ($peserta->status_rancangan_dpl == 'belum')
        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">
            <div class="flex lg:flex-row flex-col gap-y-4  gap-x-4">
                <div>
                    <span
                        class="inline-flex items-center justify-center  h-12 w-12 text-sm font-semibold text-color-danger-500 bg-color-danger-100 border border-color-danger-500 rounded-full ">
                        <i class="fas fa-exclamation text-lg"></i>
                    </span>
                </div>
                <div class="flex flex-col text-color-danger-500">
                    <p class="font-semibold">Mahasiswa Belum Mengupload Rancangan</p>
                    <p class="text-sm">Berkas Rancngan akan di setujui oleh DPL dan pamong ketika berhasil di upload</p>
                </div>
            </div>

        </div>
        @elseif($peserta->status_rancangan_dpl == 'proses')
        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">
            <div class="flex lg:flex-row flex-col gap-y-4  gap-x-4">
                <div>
                    <span
                        class="inline-flex items-center justify-center  h-12 w-12 text-sm font-semibold text-color-warning-500 bg-color-warning-100 border border-color-warning-500 rounded-full ">
                        <i class="fas fa-exclamation text-lg"></i>
                    </span>
                </div>

                <div class="flex flex-col text-color-warning-500">
                    <p class="font-semibold">Mahasiswa Sudah Mengupload Rancangan</p>
                    <p class="text-sm">Lihat berkas Rancangan mahasiswa melalui link di bawah </p>
                </div>
            </div>
            <div class="flex flex-col gap-y-2">
                <form action="" class="flex items-center w-full gap-x-2">
                    <div class="relative w-full ">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <span>
                                <i class="fas fa-link text-lg text-slate-500"></i>
                            </span>
                        </div>
                        <input type="text" id="input-group-1"
                            class="bg-gray-50 border block border-gray-300 text-gray-900  text-xs rounded-md w-full ps-12 p-4  "
                            placeholder="https://kampusmerdeka.kemdikbud.go.id/program/magang-mandiri/browse/185c2258-bf50-4211-b460-4ed6f1db081c/95ff7b3f-1a14-40f3-b142-0cdc24aa5d9a"
                            disabled value={{ $peserta->rancangan }}>
                    </div>
                    <a href="{{ $peserta->rancangan }}" target="_blank"
                        class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-3.5 me-2">
                        Lihat
                    </a>
                </form>
            </div>
            <hr>
            <div class="flex items-start mt-2">
                <span
                    class=" inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-warning-500 rounded-full ">
                    <i class="fas fa-exclamation"></i>
                </span>
                <div class="flex flex-col gap-y-2 max-w-[80%]">
                    <p class="text-sm font-semibold">Berkas rancangan berhasil di upload mahasiswa, menuggu di
                        verifikasi oleh DPL dan Pamong</p>
                </div>
            </div>
        </div>
        @elseif($peserta->status_rancangan_dpl == 'tolak')
        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">
            <div class="flex lg:flex-row flex-col gap-y-4  gap-x-4">
                <span
                    class="inline-flex items-center justify-center  h-12 w-12 text-sm font-semibold text-color-primary-500 bg-color-primary-100 border border-color-primary-500 rounded-full ">
                    <i class="fas fa-exclamation text-lg"></i>
                </span>
                <div class="flex flex-col text-color-primary-500">
                    <p class="font-semibold">Rancangan Ditolak</p>
                    <p class="text-sm">Berkas rancangan telah ditolak</p>
                </div>
            </div>

        </div>
        @else
        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">
            <div class="flex lg:flex-row flex-col gap-y-4  gap-x-4">
                <span
                    class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-color-success-500 bg-color-success-100 border border-color-success-500 rounded-full ">
                    <i class="fas fa-check text-lg"></i>
                </span>
                <div class="flex flex-col text-color-success-500">
                    <p class="font-semibold">Rancangan Diterima</p>
                    <p class="text-sm">Lihat detail rancangan mahasiswa</p>
                </div>
            </div>
            <div class="flex flex-col gap-y-2">
                <form action="" class="flex items-center w-full gap-x-2">
                    <div class="relative w-full ">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <span>
                                <i class="fas fa-link text-lg text-slate-500"></i>
                            </span>
                        </div>
                        <input type="text" id="input-group-1"
                            class="bg-gray-50 border block border-gray-300 text-gray-900  text-xs rounded-md w-full ps-12 p-4  "
                            placeholder="https://kampusmerdeka.kemdikbud.go.id/program/magang-mandiri/browse/185c2258-bf50-4211-b460-4ed6f1db081c/95ff7b3f-1a14-40f3-b142-0cdc24aa5d9a"
                            disabled value={{ $peserta->rancangan }}>
                    </div>
                    <a href="{{ $peserta->rancangan }}" target="_blank"
                        class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-3.5 me-2">
                        Lihat
                    </a>
                </form>
            </div>
            <hr>
        </div>
        @endif

        @if ($peserta->status_rancangan_dpl == 'terima' && $peserta->status_rancangan_pamong == 'terima')
        @foreach ($peserta->weeklyLog as $index => $item)
        @php
        $statusColor = '';
        $statusIcon = '';
        switch ($item->status) {
        case 'terima':
        $statusColor = 'color-success';
        $statusIcon = 'fas fa-check-circle';
        break;
        case 'proses':
        $statusColor = 'color-warning';
        $statusIcon = 'fas fa-exclamation-circle';
        break;
        case 'tolak':
        $statusColor = 'color-warning';
        $statusIcon = 'fas fa-times-circle';
        break;
        case 'belum':
        $statusColor = 'gray';
        $statusIcon = 'fas fa-clock';
        break;
        default:
        $statusColor = 'color-warning';
        $statusIcon = 'fas fa-exclamation-circle';
        break;
        }
        @endphp
        <div class="grid grid-cols-12 p-6 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="flex lg:flex-row flex-col gap-y-4 gap-x-6 w-full col-span-12">
                <span
                    class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-{{ $statusColor }}-500 bg-{{ $statusColor }}-100 border border-{{ $statusColor }}-500 rounded-full">
                    <i class="{{ $statusIcon }} text-lg"></i>
                </span>
                <div class="flex flex-col gap-y-2">
                    <h4 class="text-xl font-semibold text-{{ $statusColor }}-500">Log Book Minggu Ke-{{ $index + 1 }}
                    </h4>
                    <p class="text-sm text-{{ $statusColor }}-500">
                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->isoFormat('dddd D MMMM YYYY') }} -
                        {{ \Carbon\Carbon::parse($item->tanggal_selesai)->isoFormat('dddd D MMMM YYYY') }}</p>
                    <a href="{{ route('operator.weeklyLogbook', ['id' => $item->id]) }}"
                        class="text-white h-fit w-fit bg-{{ $statusColor }}-500 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Periksa Laporan
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @endif


    </div>
</div>