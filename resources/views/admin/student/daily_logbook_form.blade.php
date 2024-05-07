@extends('layout.admin')

@section('main')
    <section class="max-w-screen-lg min-h-screen mx-auto flex justify-center items-center py-44 px-4 lg:px-12 gap-4">

        <div class="w-full p-10 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
            <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
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
                            <a href="{{route('student.daily_logbook', ['id' => $data->id]) }}"
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
            <div class="w-full flex flex-col items-center">
                <p class="font-semibold text-lg">Laporan
                    {{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('dddd') }}</p>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($data->date)->translatedFormat('d M Y') }}</p>

            </div>
            <div class="mt-12">
                <form action="{{ route('student.daily_logbookForm.edit', $data->id) }}" method="POST" class="w-full">
                    @csrf
                    <div class="mb-4">
                        <label for="deskripsi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Deskripsi Kegiatan
                        </label>
                        <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi Kegiatan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="rencana" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Rencana Kegiatan
                        </label>
                        <textarea name="rencana" id="rencana" placeholder="Rencana Kegiatan Kegiatan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="persentase" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Persentase Pencapaian
                        </label>
                        <input type="number" max="100" name="persentase" id="persentase"
                            placeholder="Persentase Pencapaian"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
                    </div>
                    <div class="mb-4">
                        <label for="hambatan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Hambatan Dalam Kegiatan
                        </label>
                        <textarea name="hambatan" id="hambatan" placeholder="Hambatan Kegiatan"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="solusi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                            Rencana Solusi
                        </label>
                        <textarea name="solusi" id="solusi" placeholder="Rencana Solusi"
                            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs "></textarea>
                    </div>
                    <button type="submit"
                        class="text-white w-full h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Kirim
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
