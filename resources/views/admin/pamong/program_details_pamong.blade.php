@extends('layout.admin')

@section('main')
    <section class="max-w-screen-xl min-h-screen mx-auto grid grid-cols-12 py-32 px-4 lg:px-12 gap-4">
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
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Program</a>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-span-12 grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
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
            <div class="col-span-12 mt-4 flex flex-col gap-y-2">
                <div class="flex flex-col">
                    <span class="text-xs text-slate-500">Kode Kegiatan: </span>
                    <p class="text-sm">{{ $data['mitra']->lowongan->code }}</p>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-slate-500">Tahun Akademik: </span>
                    <p class="text-sm">{{ $data['mitra']->lowongan->tahun_akademik }}</p>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs text-slate-500">Semester: </span>
                    <p class="text-sm">{{ $data['mitra']->lowongan->semester }}</p>
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
        </div>

        <div class="col-span-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="col-span-12">
                <div class="flex gap-x-2 items-center text-color-primary-500">
                    <span class=""><i class="fas fa-book text-lg"></i></span>
                    <p class="text-lg font-semibold">{{ $data['mitra']->lowongan->program->name }}</p>
                </div>
            </div>
            <form id="filterForm"
                class="mt-4 col-span-12 flex gap-x-4">
                <input type="text"id="search" id="username" name="search" placeholder="Cari Nama Mahasiswa, Nim"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs ">
                <select  id="location" type="text" id="username" name="search" placeholder="Cari Nama Mahasiswa, Nim"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs ">
                    <option value="">Pilih Lokasi</option>
                    @foreach (Auth::user()->guru->lokasis as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
                <button type="submit" id="filter-button"
                class="px-5 py-2.5 w-fit text-sm font-medium text-white inline-flex items-center bg-color-primary-500 rounded-lg text-center ">
                <span class=""><i class="fas fa-search text-lg "></i></span>
            </button>
            </form>
        </div>

        <div class="lg:col-span-4 col-span-12">
            <!-- Tampilkan daftar peserta -->
            @foreach ($data['mitra']->mahasiswa as $item)
                <div class="max-h-[42rem] overflow-y-auto flex flex-col p-2">
                    <div class="relative overflow-visible hover:cursor-pointer bg-white p-6 rounded-xl w-full flex gap-x-4 border border-slate-200 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 transition-all duration-300 peserta-item"
                        onclick="showPesertaDetail({{ $item->id }})"  data-name="{{ $item->mahasiswa->name }}" data-nim="{{ $item->mahasiswa->nim }}"
                        data-location-id="{{ $item->lokasi->id }}">
                        <div class="w-16 rounded-full">
                            <img src="/images/avatar/placeholder.jpg" alt="" class="rounded-full">
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ $item->mahasiswa->name }}</p>
                            <p class="text-sm">{{ $item->mahasiswa->nim }}</p>
                            <p class="text-sm">{{ $item->lokasi->name }}</p>
                        </div>
                        @if ($item->dailyLog()->where('status', 'proses')->count() != 0)
                            <span
                                class="w-6 h-6 bg-color-danger-500 rounded-full absolute -top-2 -right-2 inline-flex justify-center items-center text-white text-xs">{{ $item->dailyLog()->where('status', 'proses')->count() }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
            <div class="mt-4 flex flex-col items-center">
                {{ $data['peserta']->links() }}
            </div>
        </div>

        <!-- Kolom kanan dengan detail peserta -->
        <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
            <div id="peserta_detail"></div> <!-- Ini adalah div tempat tampilan detail peserta akan ditampilkan -->
        </div>
    </section>

    <script>
        function showPesertaDetail(pesertaId) {
            // Menggunakan AJAX untuk mengambil detail peserta dari server
            $.ajax({
                type: 'GET',
                url: '/dashboard/pamong/get-peserta/' + pesertaId,
                success: function(response) {
                    // Memperbarui konten di sebelah kanan dengan detail peserta yang baru
                    $('#peserta_detail').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        function filterPeserta() {
            let searchValue = document.getElementById('search').value.toLowerCase();
            let locationValue = document.getElementById('location').value;

            document.querySelectorAll('.peserta-item').forEach(function(item) {
                let name = item.getAttribute('data-name').toLowerCase();
                let nim = item.getAttribute('data-nim').toLowerCase();
                let location = item.getAttribute('data-location-id');

                if ((name.includes(searchValue) || nim.includes(searchValue)) && (locationValue === "" ||
                        location === locationValue)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault();
            filterPeserta();
        });

        document.getElementById('filter-button').addEventListener('click',filterPeserta);
    </script>
@endsection
