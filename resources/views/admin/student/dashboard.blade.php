@extends('layout.admin')

@section('main')

    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
        <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{route('student.dashboard')}}"
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
            <div class="p-6 bg-white flex gap-4 items-center rounded-xl shadow-sm border border-slate-200">
                <div class=" relative w-fit">
                    <img src="/images/avatar/avatar.jpg" alt="" class="w-20 rounded-full object-cover">
                    <button
                        class="absolute right-0 bottom-0 inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-white hover:bg-slate-100 shadow-md border border-slate-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                        <i class="fas fa-pencil-alt text-xs"></i>
                    </button>
                </div>
                <div class="flex flex-col ">
                    @auth
                        <p class="font-semibold text-base uppercase">{{ Auth::user()->mahasiswa->name }}</p>
                        <span class="text-xs text-slate-500">{{ Auth::user()->mahasiswa->studi->name }}</span>
                    @endauth
                    <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span>
                </div>
            </div>
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow mt-4">
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
                                {{ 'Semester ' . ($data['programTransaction']->lowongan->semester % 2 == 0 ? 'Genap' : 'Ganjil') }}
                                {{ $data['programTransaction']->lowongan->tahun_akademik }}
                            @endif

                        </p>

                        <div class="mt-3 flex flex-col gap-y-1">
                            <span class="text-sm mt-1 font-semibold">
                                MITRA/Guru Pamong:
                            </span>
                            <p class="uppercase text-sm">
                                @if ($data['programTransaction'])
                                    @foreach ($data['programTransaction']->lokasi->teachers as $item)
                                        {{ $item->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
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
                                    @foreach ($data['programTransaction']->lokasi->dpls as $item)
                                        {{ $item->dosen->name }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </p>
                        </div>


                    </div>
                    <div class="grid grid-flow-row divide-y-[1px]">
                        <div class="flex items-center gap-4 font-semibold pb-4">
                            <a href="{{ route('student.weekly_logbook') }}" class="flex items-center gap-2 ">
                                <span><i class="fas fa-book text-base"></i></span>
                                <span>Log Book</span>
                            </a>
                        </div>

                        {{-- <div class="flex items-center gap-4 font-semibold py-4">
                        <span class=""><i class="fas fa-clipboard-check text-xl"></i></span>
                        <p class="text-sm">Log Book Mingguan</p>
                    </div> --}}
                        <div class="flex items-center gap-4 font-semibold py-4">
                            <span class=""><i class="fas fa-print text-base"></i></span>
                            <p class="text-sm">Dokumen</p>
                        </div>
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
            <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="col-span-2">
                    <img src="/images/avatar/mitra.png" alt="" class="w-16">
                </div>
                <div class="col-span-12 mt-4">
                    <h4 class="font-semibold text-lg">Lorem ipsum dolor, sit amet</h4>
                </div>
                <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
                    <span class=""><i class="fas fa-book text-sm"></i></span>
                    <p class="text-sm font-semibold">Kampus Mengajar</p>
                </div>
                <div class="col-span-12 mt-2">
                    <p class="text-sm">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque quae iure est saepe cum quod
                        quisquam,
                        iste dolore obcaecati accusamus earum laborum magni incidunt id voluptas consequuntur explicabo
                        corrupti
                        alias.
                    </p>
                </div>
                <div class="col-span-12 mt-4 flex flex-col gap-y-2">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Kode Kegiatan: </span>
                        <p class="text-sm">541341243</p>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Priode Kegiatan: </span>
                        <p class="text-sm">14 Agu 2023 - 31 Des 2023 <span class="text-slate-500">(5 bulan)</span></p>
                    </div>
                </div>
                <hr class="col-span-12 mt-4">
                <div class="col-span-12 mt-4 flex flex-col gap-y-4">
                    <div class="flex items-center">
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
                    </div>
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
            <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="col-span-12 flex flex-col gap-y-2">
                    <h4 class="text-xl font-semibold">Lokasi Kegiatan</h4>
                    <p class="text-sm">Kamu akan mengikuti kegiatan dari tanggal 14 Agu - 31 Des 2023.</p>
                </div>
            </div>

        </div>
    </section>
@endsection
