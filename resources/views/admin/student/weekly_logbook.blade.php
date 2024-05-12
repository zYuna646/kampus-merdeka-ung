@extends('layout.admin')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
        <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('student.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Log
                            Book</a>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-span-12 lg:col-span-4 w-full">
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
                <a href="#" class="w-full">
                    <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
                </a>
                <div class="p-6">
                    <div class="mb-8">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-x-2 items-center text-color-primary-500">
                                <span class=""><i class="fas fa-book text-sm"></i></span>
                                <p class="text-sm font-semibold">
                                    @if ($data['programTransaction'])
                                        {{ $data['programTransaction']->lowongan->program->name }}
                                    @endif
                                </p>
                            </div>
                            <span>
                                <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
                            </span>
                        </div>
                        <p class="text-base mt-1">
                            @if ($data['programTransaction'])
                                {{ $data['programTransaction']->lokasi->name }}
                            @endif
                        </p>
                        <p class="text-sm mt-1 text-slate-500">
                            @if ($data['programTransaction'])
                                {{ 'Semester ' . $data['programTransaction']->lowongan->semester }}
                                {{ $data['programTransaction']->lowongan->tahun_akademik }}
                            @endif
                        </p>
                        <div class="mt-3 flex flex-col gap-y-1">
                            <span class="text-sm mt-1 font-semibold">
                                MITRA/Guru Pamong :
                            </span>
                            <p class="uppercase text-sm">
                                @if ($data['programTransaction'])
                                    @foreach ($data['programTransaction']->pamong as $item)
                                        {{ $item->guru->name }}
                                    @endforeach
                                @endif
                            </p>
                        </div>
                        <div class="mt-3 flex flex-col gap-y-1">
                            <p class="text-sm mt-1 font-semibold">
                                DPL :
                            </p>
                            <p class="uppercase text-sm">
                                @if ($data['programTransaction'])
                                    @foreach ($data['programTransaction']->dpls as $item)
                                        {{ $item->dosen->name }}
                                    @endforeach
                                @endif
                            </p>
                        </div>

                    </div>
                    {{-- <div class="flex items-center gap-4 font-semibold pb-4">
                        <span class=""><i class="fas fa-hourglass-half text-base"></i></span>
                        <p class="text-sm">2 Logbook menunggu disetujui</p>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 w-full flex flex-col gap-y-2">
            @if ($data['programTransaction'])
                <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow flex flex-col gap-y-4">
                    <div class="flex  gap-x-4">
                        <span
                            class="inline-flex items-center justify-center max-w-8 max-h-8 h-full w-full text-sm font-semibold text-color-danger-500 bg-color-danger-100 border border-color-danger-500 rounded-full ">
                            <i class="fas fa-exclamation text-lg"></i>
                        </span>
                        <div class="flex flex-col text-color-danger-500">
                            <p class="font-semibold">Rancangan Kegiatan Belum Di Upload</p>
                            <p class="text-sm">Masukan link dokumen rancangan kegiatan pada form dibawah ini</p>
                        </div>
                    </div>
                    <hr>
                    <div class="flex flex-col gap-y-2">
                        <form action="{{ route('student.rancangan.submit', ['id' => $data['programTransaction']->id]) }}" method="POST">
                            @csrf
                            <div class="relative mb-2">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <span>
                                        <i class="fas fa-link text-lg text-slate-500"></i>
                                    </span>
                                </div>
                                <input type="text" id="input-group-1" name="rancangan"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 xl:text-sm text-xs rounded-md w-full pl-12 py-2"
                                    placeholder="http://">
                            </div>
                            <button type="submit"
                                class="text-white w-fit bg-red-500 hover:bg-red-600 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                Upload Rancangan
                            </button>
                        </form>
                    </div>


                </div>
                @if (
                    $data['programTransaction']->status_rancangan_dpl == 'terima' &&
                        $data['programTransaction']->status_rancangan_pamong == 'terima')
                    @foreach ($data['programTransaction']->weeklyLog as $index => $item)
                        <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow ">
                            <div class="flex justify-between flex-col lg:flex-row gap-y-4">
                                <div class="flex flex-col gap-y-1">
                                    <div class="flex gap-x-2 items-center">
                                        @switch($item->status)
                                            @case('terima')
                                                <span class="text-green"><i class="fas fa-marker text-sm"></i></span>
                                                <span class="text-green-500">Diterima</span>
                                            @break

                                            @case('proses')
                                                <span class="text-yellow"><i class="fas fa-marker text-sm"></i></span>
                                                <span class="text-yellow-500">Sedang Diproses</span>
                                            @break

                                            @case('tolak')
                                                <span class="text-red"><i class="fas fa-marker text-sm"></i></span>
                                                <span class="text-red-500">Ditolak</span>
                                            @break

                                            @default
                                                <span class="text-gray"><i class="fas fa-marker text-sm"></i></span>
                                                <span class="text-gray-500">Belum Dibuat</span>
                                        @endswitch
                                    </div>
                                    @php
                                        $startDate = \Carbon\Carbon::parse($item->start_date);
                                        $endDate = \Carbon\Carbon::parse($item->end_date);
                                    @endphp

                                    <p class="font-semibold">
                                        {{ $startDate->format('d') }} - {{ $endDate->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-slate-500">Minggu Ke-{{ $index + 1 }}</p>
                                </div>
                                <div class="flex gap-x-2">
                                    @foreach ($item->daily as $dailyItem)
                                        @php
                                            // Mengambil nama hari dari tanggal dalam Bahasa Indonesia
                                            $dayName = \Carbon\Carbon::parse($dailyItem->date)
                                                ->locale('id')
                                                ->isoFormat('dddd');
                                            // Mendapatkan inisial dari nama hari
                                            $dayInitial = substr($dayName, 0, 1);

                                            // Menentukan warna dan ikon berdasarkan status
                                            $colorClass = '';
                                            $iconClass = '';
                                            switch ($dailyItem->status) {
                                                case 'terima':
                                                    $colorClass = 'bg-green-500';
                                                    $iconClass = 'fas fa-check';
                                                    break;
                                                case 'proses':
                                                    $colorClass = 'bg-yellow-500';
                                                    $iconClass = 'fas fa-hourglass-half';
                                                    break;
                                                case 'tolak':
                                                    $colorClass = 'bg-red-500';
                                                    $iconClass = 'fas fa-times';
                                                    break;
                                                default:
                                                    $colorClass = 'bg-gray-500';
                                                    $iconClass = 'fas fa-minus';
                                            }
                                        @endphp

                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-sm text-slate-500">{{ $dayInitial }}</span>
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold text-white rounded-full {{ $colorClass }}">
                                                <i class="{{ $iconClass }} text-sm"></i>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr class="mt-4 mb-4">
                            <div class="flex flex-col justify-center items-start">
                                @php
                                    $allTerima = true;
                                    foreach ($item->daily as $key => $value) {
                                        if ($value->status !== 'terima') {
                                            $allTerima = false;
                                            break;
                                        }
                                    }
                                @endphp
                                <a href="{{ route('student.daily_logbook', ['id' => $item->id]) }}"
                                    class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                    Lengkapi Laporan Harian
                                </a>
                                <form id="weeklyForm" method="POST"
                                    action="{{ route('student.weekly_logbookForm.edit', ['id' => $item->id]) }}">
                                    @csrf
                                    <!-- You can include any hidden inputs or other form elements here -->
                                </form>

                                @if ($allTerima && $item->status == 'belum')
                                    <a href="#" onclick="submitWeeklyForm()"
                                        class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                        Buat Laporan Mingguan
                                    </a>
                                @endif

                                <script>
                                    function submitWeeklyForm() {
                                        document.getElementById('weeklyForm').submit(); // Submit the form
                                    }
                                </script>



                                <p class="text-sm text-slate-500">Laporan mingguan dapat di isi ketika laporan harian sudah
                                    lengkap</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif

        </div>
    </section>
@endsection
