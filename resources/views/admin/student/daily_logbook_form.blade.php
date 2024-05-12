@extends('layout.admin')

@section('main')
    <section class="max-w-screen-lg min-h-screen mx-auto grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
        <div class=" mb-2 mt-2 col-span-12" aria-label="Breadcrumb">
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
                        <a href="{{ route('student.daily_logbook', ['id' => $data->id]) }}"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Harian</a>
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
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Form</a>
                    </div>
                </li>
            </ol>
        </div>
        <div class="w-full p-10 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col col-span-12">

            <div class="w-full flex flex-col items-center">
                <p class="font-semibold text-lg">Laporan
                    {{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('dddd') }}</p>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($data->date)->translatedFormat('d M Y') }}</p>

            </div>
            <div class="mt-12">
                <form action="{{ route('student.daily_logbookForm.edit', $data->id) }}" method="POST"
                    class="w-full grid grid-cols-12 gap-4">
                    <div class="col-span-6 flex items-center gap-x-2">
                        <label for="deskripsi" class="block text-xs xl:text-sm text-gray-900 dark:text-white">
                            Jumlah Kegiatan :
                        </label>
                        <input type="number" max="100" name="jumlah" id="persentase" placeholder="Jumlah"
                            class="block p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
                            oninput="updateKegiatan()" />
                    </div>
                    <div id="kegiatan-container" class="col-span-12">

                    </div>
                    <div class="mb-4">
                        <label for="dokumentasi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Dokumentasi
                        </label>
                        <input type="text" name="dokumentasi" id="dokumentasi" placeholder="http://example.com"
                            class="w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
                    </div>



                    <button type="submit"
                        class="text-white w-full h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </section>
    <script>
        // Menggunakan kelas 'detailContainer' sebagai selektor umum untuk semua elemen yang ingin Anda kontrol
        const detailContainers = document.querySelectorAll('.detailContainer');

        // Fungsi openDetails menerima parameter elemen yang diklik
        const openDetails = (element, event) => {
            // Temukan kontainer detail yang sesuai dengan elemen yang diklik
            const detailContainer = element.nextElementSibling;
            event.preventDefault();

            // Periksa apakah detailContainer memiliki kelas 'hidden'
            if (detailContainer.classList.contains('hidden')) {
                // Jika memiliki kelas 'hidden', hapus kelas tersebut
                detailContainer.classList.remove('hidden');
                detailContainer.classList.add('flex');
            } else {
                // Jika tidak memiliki kelas 'hidden', tambahkan kelas tersebut
                detailContainer.classList.remove('flex');
                detailContainer.classList.add('hidden');
            }
        };

        function updateKegiatan() {
            // Ambil nilai jumlah kegiatan dari input
            var jumlahKegiatan = parseInt(document.getElementById('persentase').value);

            // Ambil kontainer div untuk menempatkan kegiatan
            var kegiatanContainer = document.getElementById('kegiatan-container');

            // Hapus semua kegiatan sebelum menambahkan yang baru
            kegiatanContainer.innerHTML = '';

            // Buat jumlah kegiatan sesuai dengan nilai yang dimasukkan
            for (var i = 1; i <= jumlahKegiatan; i++) {
                var kegiatanDiv = document.createElement('div');
                kegiatanDiv.className = 'mb-4';
                kegiatanDiv.innerHTML = `
                <div class=" p-6 bg-slate-100 rounded-xl flex flex-col gap-y-4">
                    <button class="flex justify-between" onclick="openDetails(this, event)">
                        <p class="font-semibold">Kegiatan ${i}</p>
                        <span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </span>
                    </button>
                    <div class="detailContainer flex flex-col">
                        @csrf
                        <div class="mb-4">
                            <label for="deskripsi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                                Deskripsi Kegiatan
                            </label>
                            <textarea name="deskripsi${i}" id="deskripsi" placeholder="Deskripsi Kegiatan"
                                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="rencana" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                                Rencana Kegiatan
                            </label>
                            <textarea name="rencana${i}" id="rencana" placeholder="Rencana Kegiatan Kegiatan"
                                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                        </div>
                        <div class="mb-4">
    <label for="jam_mulai" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
        Jam Mulai
    </label>
    <input type="time" name="jam_mulai${i}" id="jam_mulai" class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
</div>

<div class="mb-4">
    <label for="jam_selesai" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
        Jam Selesai
    </label>
    <input type="time" name="jam_selesai${i}" id="jam_selesai" class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
</div>

                        <div class="mb-4">
                            <label for="persentase" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                                Persentase Pencapaian
                            </label>
                            <input type="number" max="100" name="persentase${i}" id="persentase"
                                placeholder="Persentase Pencapaian"
                                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
                        </div>
                        <div class="mb-4">
                            <label for="hambatan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                                Hambatan Dalam Kegiatan
                            </label>
                            <textarea name="hambatan${i}" id="hambatan" placeholder="Hambatan Kegiatan"
                                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="solusi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                                Rencana Solusi
                            </label>
                            <textarea name="solusi${i}" id="solusi" placeholder="Rencana Solusi"
                                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                        </div>
                    </div>
                </div>
            `;
                kegiatanContainer.appendChild(kegiatanDiv);
            }
        }
    </script>
@endsection
