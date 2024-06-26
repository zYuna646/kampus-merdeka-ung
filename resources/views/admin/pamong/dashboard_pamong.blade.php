@extends('layout.admin')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 p-32 px-4 lg:px-12 gap-4">
        <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('guru.dashboard') }}"
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
            <div class="p-6 bg-white grid grid-cols-12 gap-4 items-center rounded-xl shadow-sm border border-slate-200">
                <div class=" relative w-fit col-span-3">
                    <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full object-cover">

                </div>
                <div class="flex flex-col col-span-9">
                    @auth
                        <p class="font-semibold text-base uppercase">{{ Auth::user()->guru->name }} </p>
                        <span class="text-xs text-slate-500"> {{ Auth::user()->guru->nik }}</span>
                        <span class="text-slate-500 text-sm">
                            @foreach (Auth::user()->guru->lokasis as $item)
                                {{ $item->name . ',' }}
                            @endforeach
                        </span>
                    @endauth

                </div>
            </div>
            <div class="p-6 w-full bg-white flex flex-col gap-4 rounded-xl shadow-sm border border-slate-200 mt-2">
                <form action="" class="w-full">
                    <div class="mb-2 w-full">
                        <select type="text" id="input-group-1" name="program" id="program" placeholder=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Program</option>
                            @foreach ($data['program_kampus'] as $item)
                                <option value={{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2 w-full">
                        <select type="text" name="tahun" id="input-group-2" placeholder=""
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
                            <option value="">Pilih Tahun Akademik</option>
                        </select>
                    </div>
                    <div class="col-span-3 lg:col-span-1">
                        <button type="button" id="filter-button"
                            class="text-white w-full h-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-base px-5 py-3.5 me-2">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
            <p class="text-sm italic my-4">Total Program : <span>{{ $data['program']->count() }} </span></p>
            <div class="w-full max-h-[42rem] overflow-y-auto flex flex-col gap-y-4">
                @if ($data['program'])
                    {{-- Menampilkan hanya programTransaction unik berdasarkan lowongan_id dan lokasi_id --}}
                    @foreach ($data['program'] as $program)
                        <a href="{{ route('guru.program.detail', ['lowongan_id' => $program->lowongan->id]) }}"  data-program-id="{{ $program->lowongan->program->id }}" data-tahun-akademik="{{ $program->lowongan->tahun_akademik }}"
                            class="lowongan-item w-full block bg-white border border-gray-200 hover:border-color-primary-500 hover:bg-slate-100 transition-colors duration-300 rounded-lg shadow">

                            <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png"
                                alt="" />

                            <div class="p-6">
                                <div class="">
                                    <div class="flex justify-between items-center">
                                        <div class="flex gap-x-2 items-center text-color-primary-500">
                                            <span class=""><i class="fas fa-book text-sm"></i>
                                                {{ $program->lowongan->program->name }}</span>
                                            <p class="text-sm font-semibold">{{-- Masukkan informasi yang sesuai di sini --}}</p>
                                        </div>
                                        <span>
                                            <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
                                        </span>
                                    </div>

                                    <p class="text-sm mt-1 text-slate-500">
                                        {{ 'Semester ' . $program->lowongan->semester }}
                                        {{ $program->lowongan->tahun_akademik }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>


        </div>
        <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
            <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
                <div class="col-span-2">
                    <img src="/images/avatar/ung.png" alt="" class="w-16">
                </div>
                {{-- <div class="col-span-12 mt-4">
                <h4 class="font-semibold text-lg">Lorem ipsum dolor, sit amet</h4>
            </div> --}}
                <div class="col-span-12 flex gap-x-2 items-center text-color-primary-500 mt-2">
                    <span class=""><i class="fas fa-book text-sm"></i></span>
                    <p class="text-sm font-semibold">{{ $data['mitra']->lowongan->program->name }}</p>
                </div>
                {{-- <div class="col-span-12 mt-2">
                <p class="text-sm">
                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque quae iure est saepe cum quod
                    quisquam,
                    iste dolore obcaecati accusamus earum laborum magni incidunt id voluptas consequuntur explicabo
                    corrupti
                    alias.
                </p>
            </div> --}}
                <div class="flex items-center col-span-12 mt-2 mb-2">
                    <span
                        class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full ">
                        <i class="fas fa-check"></i>
                    </span>
                    <p class="text-sm font-semibold">{{ $data['mitra']->mahasiswa->count() }} Mahasiswa Terdaftar</p>
                </div>
                <div class="col-span-12 mt-2 flex flex-col gap-y-2">
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Kode Kegiatan: </span>
                        <p class="text-sm">{{ $data['mitra']->lowongan->code }}</p>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs text-slate-500">Priode Kegiatan: </span>
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($data['mitra']->lowongan->tanggal_mulai);
                            $tanggalSelesai = \Carbon\Carbon::parse($data['mitra']->lowongan->tanggal_selesai);
                            $selisihBulan = $tanggalMulai->diffInMonths($tanggalSelesai);
                        @endphp

                        <p class="text-sm">
                            {{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                            {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}
                            <span class="text-slate-500">({{ $selisihBulan }} bulan)</span>
                        </p>
                    </div>
                </div>
                <hr class="col-span-12 mt-4">
                <div class="col-span-12 mt-4 flex gap-x-1">
                    <a type="button"
                        href="{{ route('guru.program.detail', ['lowongan_id' => $data['mitra']->lowongan->id]) }}"
                        class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Detail Program
                    </a>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement2 = document.getElementById('input-group-2');
            const startYear = 2020;
            const endYear = 2050;

            for (let year = startYear; year <= endYear; year++) {
                const academicYear = `${year}-${year + 1}`;
                const option = document.createElement('option');
                option.value = academicYear;
                option.textContent = academicYear;
                selectElement2.appendChild(option);
            }

            document.getElementById('filter-button').addEventListener('click', function() {
                const programId = document.getElementById('input-group-1').value;
                const tahunAkademik = document.getElementById('input-group-2').value;
                filterLowongan(programId, tahunAkademik);
            });
        });

        function filterLowongan(programId, tahunAkademik) {
            const lowonganItems = document.querySelectorAll('.lowongan-item');
            let totalLowongan = 0;
            console.log(programId, tahunAkademik);
            lowonganItems.forEach(item => {
                const itemProgramId = item.getAttribute('data-program-id');
                const itemTahunAkademik = item.getAttribute('data-tahun-akademik');

                if ((programId === '' || itemProgramId === programId) && (tahunAkademik === '' || itemTahunAkademik === tahunAkademik)) {
                    item.style.display = 'block';
                    totalLowongan++;
                } else {
                    item.style.display = 'none';
                }
            });

            document.getElementById('total-lowongan').textContent = totalLowongan;
        }
    </script>
@endsection
