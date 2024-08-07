@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
    <div class="flex col-span-12 mt-2 w-full" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('student.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Beranda
                </a>
            </li>
        </ol>
    </div>
    <div class="p-6 bg-white rounded-lg border border-slate-200 shadow col-span-12 min-h-96 w-full">
        <h3 class="font-semibold text-lg">Histori Program</h3>

        {{-- <div class="flex flex-col items-center justify-center">
            <img src="/images/avatar/Search-for-Ideas.png" alt="" class="w-52">
            <p class="text-sm font-semibold">Ops!, Kamu Belum Menyelesaikan Program Apapun</p>
        </div> --}}
        <div class="grid grid-flow-row p-4  gap-4">
            @foreach ($data as $item)
            <div class="flex lg:flex-row flex-col gap-y-6 justify-between  border-b lg:items-center lg:p-4 pb-4 mb-2 ">
                <div class="w-full">
                    <div class="flex flex-col gap-y-4 w-full">
                        <div class="flex items-start gap-x-4 w-full">
                            <img src="/images/avatar/ung.png" alt="" class="w-12">
                            <div class="flex flex-col lg:flex-row justify-between lg:items-center w-full">
                                <div class="flex flex-col">
                                    <p class="font-semibold inline-flex items-center gap-x-2">
                                        {{ optional($item->lokasi)->name }}
                                    </p>
                                    @php
                                    $tanggalMulai = \Carbon\Carbon::parse($item->lowongan->tanggal_mulai);
                                    $tanggalSelesai = \Carbon\Carbon::parse($item->lowongan->tanggal_selesai);
                                    $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                                    @endphp
                                    <p class="text-sm"> {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                                        {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}</p>
                                    <p class="text-sm"> {{$item->lowongan->tahun_akademik }}</p>
                                    <p class="text-sm"> {{$item->lowongan->semester}}</p>
                                    <div class="flex gap-x-2 items-center text-color-primary-500">
                                        <span class=""><i class="fas fa-book text-sm"></i></span>
                                        <p class="text-sm font-semibold">
                                            Kampus Mengajar
                                        </p>
                                    </div>
                                    @if ($item->status_mahasiswa)
                                    <span
                                        class="py-1 px-2 rounded-md font-semibold bg-color-info-100 text-color-info-500 text-xs w-fit mt-3">
                                        Diterima
                                    </span>
                                    @else
                                    <span
                                        class="py-1 px-2 rounded-md font-semibold bg-color-success-100 text-color-success-500 text-xs w-fit mt-3">
                                        Diproses
                                    </span>
                                    @endif

                                </div>
                                <div class="flex flex-col gap-y-2 items-start lg:items-end mt-4">
                                    @if ($item->status_mahasiswa)
                                    <a href=" {{ route('student.weekly_logbook', $item->id) }} }}"
                                        class=" h-fit w-fit cursor-pointer bg-white border border-slate-900 text-slate-900 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                        Lihat Detail
                                    </a>
                                    
                                    @endif
                                    <a href=" {{ route('student.download_sk', $item->id) }} }}"
                                        class=" h-fit w-fit cursor-pointer bg-white border border-slate-900 text-slate-900 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                        Lihat SK Rektor
                                    </a>
                                    <a href=" {{ route('student.download_surat', $item->id) }} }}"
                                        class=" h-fit w-fit cursor-pointer bg-white border border-slate-900 text-slate-900 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                        Download Surat
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach

        </div>
    </div>
</section>
@endsection