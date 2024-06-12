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
            </ol>
        </div>

        <div class="lg:col-span-4 col-span-12  w-full ">
            <div class="p-6  bg-white grid grid-cols-12 gap-4 items-center rounded-xl shadow-sm border border-slate-200">
                <div class="col-span-3 relative w-fit">
                    <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full object-cover">
                </div>
                <div class="col-span-9 flex flex-col ">
                    @auth
                        <p class="font-semibold text-base uppercase">{{ Auth::user()->mahasiswa->name }}</p>
                        <span class="text-xs text-slate-500">{{ Auth::user()->mahasiswa->studi->name }}</span>
                    @endauth
                    <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span>
                </div>
            </div>
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow mt-4">
                <div href="#" class="w-full">
                    <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
                </div>
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
                                MITRA/Guru Pamong:
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
                                DPL:
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
                    <div class="grid grid-flow-row divide-y-[1px]">
                        {{-- <div class="flex items-center gap-4 font-semibold py-4">
                        <span class=""><i class="fas fa-clipboard-check text-xl"></i></span>
                        <p class="text-sm">Log Book Mingguan</p>
                    </div> --}}
                        <a href="{{ route('student.weekly_logbook') }}" class="flex items-center gap-4 font-semibold py-4">
                            <span class=""><i class="fas fa-print text-base"></i></span>
                            <p class="text-sm">Log Book</p>
                        </a>
                        <div class="flex items-center gap-4 font-semibold pt-4">
                            <span><i class="fas fa-sign-out-alt text-base"></i></span>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="text-sm">
                                Keluar
                            </a>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

                    </div>
                </div>
            </div>

        </div>
        <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">

            @if ($data['programTransaction'])
                <div class="grid grid-cols-12 p-8 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="col-span-2">
                        <img src="/images/avatar/ung.png" alt="" class="w-16">
                    </div>
                    <div class="col-span-12 mt-4">
                        <h4 class="font-semibold text-lg">{{ $data['programTransaction']->lokasi->name }}</h4>
                    </div>
                    <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
                        <span class=""><i class="fas fa-book text-sm"></i></span>
                        <p class="text-sm font-semibold">{{ $data['programTransaction']->lowongan->program->name }}</p>
                    </div>
                    {{-- <div class="col-span-12 mt-2">
                <p class="text-sm">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque quae iure est saepe cum
                    quod
                    quisquam,
                    iste dolore obcaecati accusamus earum laborum magni incidunt id voluptas consequuntur explicabo
                    corrupti
                    alias.
                </p>
            </div> --}}
                    <div class="col-span-12 mt-4 flex flex-col gap-y-2">
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Kode Kegiatan: </span>
                            <p class="text-sm">{{ $data['programTransaction']->lowongan->code }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Tahun Akademik: </span>
                            <p class="text-sm">{{ $data['programTransaction']->lowongan->tahun_akademik }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Semester: </span>
                            <p class="text-sm">{{ $data['programTransaction']->lowongan->semester }}</p>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Priode Kegiatan: </span>
                            @php
                                $tanggalMulai = \Carbon\Carbon::parse(
                                    $data['programTransaction']->lowongan->tanggal_mulai,
                                );
                                $tanggalSelesai = \Carbon\Carbon::parse(
                                    $data['programTransaction']->lowongan->tanggal_selesai,
                                );
                                $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                            @endphp

                            <p class="text-sm">
                                {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                                {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                                <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                            </p>

                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-slate-500">Status Pendaftaran: </span>
                            @if ($data['programTransaction']->status_mahasiswa)
                                <div class="flex items-center mt-2">
                                    <span
                                        class=" inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full ">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <div class="flex flex-col gap-y-2 max-w-[80%]">
                                        <p class="text-sm font-semibold ">Berhasil Terverikasi</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center mt-2">
                                    <span
                                        class=" inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-warning-500 rounded-full ">
                                        <i class="fas fa-exclamation"></i>
                                    </span>
                                    <div class="flex flex-col gap-y-2 max-w-[80%]">
                                        <p class="text-sm font-semibold ">Sedang Ditinjau</p>
                                    </div>
                                </div>
                            @endif

                            {{-- <div class="flex items-center mt-2">
                                <span
                                    class=" inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-danger-500 rounded-full ">
                                    <i class="fas fa-times"></i>
                                </span>
                                <div class="flex flex-col gap-y-2 max-w-[80%]">
                                    <p class="text-sm font-semibold ">Ditolak</p>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                    <hr class="col-span-12 mt-4">
                    <div class="col-span-12 mt-4 flex flex-col gap-y-4">
                        {{-- <div class="flex items-center">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-warning-500 rounded-full ">
                        <i class="fas fa-exclamation"></i>
                    </span>
                    <p class="text-sm font-semibold">Log Book Minggu Ke-2 Belum Terisi</p>
                </div>
                <div class="flex items-center">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full ">
                        <i class="fas fa-check"></i>
                    </span>
                    <p class="text-sm font-semibold">Laporan Permohonan Disetujui</p>
                </div> --}}
                    </div>

                    {{--
            <hr class="col-span-12 mt-4">
            <div class="col-span-12 mt-4 flex gap-x-1">
                <button type="button"
                    class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                    Daftar
                </button>
                <button type="button"
                    class="px-5 py-2.5 w-fit text-sm font-medium text-slate-900 inline-flex items-center bg-white border border-slate-900 rounded-lg text-center ">
                    <span class=""><i class="far fa-bookmark text-sm me-2"></i></span>
                    Simpan
                </button>
            </div> --}}
                </div>
                <div class="grid grid-cols-12 p-8 bg-white rounded-xl border border-slate-200 shadow-sm">
                    <div class="col-span-12 flex flex-col gap-y-2">
                        <h4 class="text-xl font-semibold">Periode Kegiatan</h4>
                        <p class="text-sm">Kamu akan mengikuti kegiatan dari tanggal
                            {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                            {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                            <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                        </p>
                    </div>
                </div>
            @else
                <div class="w-full flex flex-col items-center justify-center gap-y-2">
                    <div class="w-56">
                        <img src="/images/avatar/Search-for-Ideas.png" alt="">
                    </div>
                    <div class="max-w-sm flex flex-col gap-y-4 items-center">
                        <p class="text-center">Ups!! Saat ini kamu belum terdaftar di program manapun</p>
                        <x-button_md>
                            Cari Program
                        </x-button_md>
                    </div>
                </div>
            @endif
        </div>


    </section>
@endsection
