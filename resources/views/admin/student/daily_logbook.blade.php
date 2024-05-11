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
                        <a href="{{ route('student.weekly_logbook') }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Log
                            Book</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Harian</a>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-span-4 w-full">
            {{-- <div class="w-full bg-white border border-gray-200 rounded-lg shadow">
      <a href="#" class="w-full">
        <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
      </a>
      <div class="p-6">
        <div class="mb-8">
          <div class="flex justify-between items-center">
            <div class="flex gap-x-2 items-center text-color-primary-500">
              <span class=""><i class="fas fa-book text-sm"></i></span>
              <p class="text-sm font-semibold">Kampus Mengajar</p>
            </div>
            <span>
              <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
            </span>
          </div>
          <p class="text-base mt-1">
            SDN 6 Telaga Biru Kota Gorontalo
          </p>
          <p class="text-sm mt-1 text-slate-500">
            Semester Ganjil 2023/2024
          </p>
          <div class="mt-3 flex flex-col gap-y-1">
            <span class="text-sm mt-1 font-semibold">
              MITRA/Guru Pamong :
            </span>
            <p class="uppercase text-sm">
              Suryato Bilal Bil Halal
            </p>
          </div>
          <div class="mt-3 flex flex-col gap-y-1">
            <p class="text-sm mt-1 font-semibold">
              DPL :
            </p>
            <p class="uppercase text-sm">
              Ali Bin Abi Thalib
            </p>
          </div>

        </div>
        <div class="flex items-center gap-4 font-semibold pb-4">
          <span class=""><i class="fas fa-hourglass-half text-base"></i></span>
          <p class="text-sm">2 Logbook menunggu disetujui</p>
        </div>
      </div>
    </div> --}}
            <div class="w-full bg-white p-6 rounded-lg shadow broder border-gray-200">
                {{-- <div class="flex gap-x-2 items-center text-color-danger-500">
        <span class=""><i class="fas fa-pen text-sm"></i></span>
        <p class="text-sm font-semibold">Perlu Revisi</p>
      </div> --}}
                <div class="flex flex-col mt-4">
                    @php
                        $startDate = \Carbon\Carbon::parse($data->start_date);
                        $endDate = \Carbon\Carbon::parse($data->end_date);
                    @endphp
                    <p class="font-semibold text-lg">{{ $startDate->format('d') }} - {{ $endDate->format('d M Y') }}</p>
                    {{-- <span class="text-sm text-slate-500">Minggu Ke-10</span> --}}
                </div>
                <hr class="mb-4 mt-4">
                <div class="flex mt-4 justify-between">
                    @foreach ($data->daily as $dailyItem)
                        @php
                            // Mendapatkan inisial hari
                            $dayName = \Carbon\Carbon::parse($dailyItem->date)
                                ->locale('id')
                                ->isoFormat('dd');

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
                            <p>{{ $dayInitial }}</p>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white rounded-full {{ $colorClass }}">
                                <i class="{{ $iconClass }} text-sm"></i>
                            </span>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <div class="col-span-8 w-full flex flex-col gap-y-2">
            @foreach ($data->daily as $dailyItem)
                @php
                    // Mendapatkan inisial hari
                    $dayName = \Carbon\Carbon::parse($dailyItem->date)
                        ->locale('id')
                        ->isoFormat('dddd');
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
                <div class="p-8 bg-white w-full rounded-xl border border-gray-200 shadow">
                    <div class="flex gap-x-4 items-center">
                        <span
                            class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-white rounded-full {{ $colorClass }}">
                            <i class="{{ $iconClass }} text-lg"></i>
                        </span>
                        <div class="flex flex-col">
                            <p class="font-semibold">{{ $dayName }}</p>
                            <span
                                class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($dailyItem->date)->format('d M Y') }}</span>
                        </div>
                    </div>

                    @if ($dailyItem->desc)
                        <div class="mt-4 flex-col gap-y-4  detailContainer">
                            <div>
                                <span class="font-semibold text-sm">Deskripsi Kegiatan:</span>
                                <p class="text-xs mt-2">{{ json_decode($dailyItem->desc)->deskripsi }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-sm mb-4">Rencana Kegiatan:</span>
                                <p class="text-xs mt-2">{{ json_decode($dailyItem->desc)->rencana }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-sm">Persentase Pencapaian:</span>
                                <p class="font-semibold">{{ json_decode($dailyItem->desc)->persentase }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-sm">Hambatan Kegiatan:</span>
                                <p class="text-xs mt-2">{{ json_decode($dailyItem->desc)->hambatan }}</p>
                            </div>
                            <div>
                                <span class="font-semibold text-sm">Rencana Solusi:</span>
                                <p class="text-xs mt-2">{{ json_decode($dailyItem->desc)->solusi }}</p>
                            </div>
                        </div>
                    @endif


                    @if ($dailyItem->status === 'tolak')
                        <div
                            class="flex items-center justify-center gap-x-4 w-full p-4 bg-white border border-color-danger-600 mt-4 rounded-xl text-color-danger-600">
                            <p class="text-sm">{{ $dailyItem->msg }}</p>
                        </div>
                        <div class="mt-4">
                            <!-- Button untuk revisi -->
                            <a href="{{ route('student.daily_logbookForm', ['id' => $dailyItem->id]) }}"
                                class="text-white h-fit w-fit bg-color-danger-500 hover:bg-color-danger-600 focus:ring-4 focus:ring-color-danger-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                Revisi
                            </a>
                        </div>
                    @elseif ($dailyItem->status === 'belum')
                        <div class="mt-4">
                            <!-- Button untuk membuat laporan -->
                            <a href="{{ route('student.daily_logbookForm', ['id' => $dailyItem->id]) }}"
                                class="text-white h-fit w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                Buat Laporan Hari Ini
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
@endsection
