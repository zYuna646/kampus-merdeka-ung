@extends('layout.admin')

@section('main')
    <section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
        <div class="flex col-span-12 mt-2 w-full" aria-label="Breadcrumb">
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
        <div class="p-6 bg-white rounded-lg border border-slate-200 shadow col-span-12 min-h-96 w-full">
            <h3 class="font-semibold text-lg">Histori Program</h3>

            {{-- <div class="flex flex-col items-center justify-center">
            <img src="/images/avatar/Search-for-Ideas.png" alt="" class="w-52">
            <p class="text-sm font-semibold">Ops!, Kamu Belum Menyelesaikan Program Apapun</p>
        </div> --}}
            <div class="grid grid-flow-row p-4 gap-4">
                @foreach ($data as $item)
                    <div
                        class="flex lg:flex-row flex-col gap-y-6 justify-between border-b lg:items-center lg:p-4 pb-4 mb-2 ">
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
                                                $tanggalSelesai = \Carbon\Carbon::parse(
                                                    $item->lowongan->tanggal_selesai,
                                                );
                                            @endphp
                                            <p class="text-sm">{{ $tanggalMulai->isoFormat('D MMM YYYY') }} -
                                                {{ $tanggalSelesai->isoFormat('D MMM YYYY') }}</p>
                                            <p class="text-sm">{{ $item->lowongan->tahun_akademik }}</p>
                                            <p class="text-sm">{{ $item->lowongan->semester }}</p>
                                            <div class="flex gap-x-2 items-center text-color-primary-500">
                                                <span class=""><i class="fas fa-book text-sm"></i></span>
                                                <p class="text-sm font-semibold">Kampus Mengajar</p>
                                            </div>
                                            {{-- Only show status_mahasiswa if status_pembayran is true --}}
                                            @if ($item->status_pembayran)
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
                                            @endif
                                        </div>
                                        <div class="flex flex-col gap-y-2 items-start lg:items-end mt-4">
                                            @if ($item->status_mahasiswa && $item->status_pembayran)
                                                <a href="{{ route('student.weekly_logbook', $item->id) }}"
                                                    class="h-fit w-fit cursor-pointer bg-white border border-slate-900 text-slate-900 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                                                    Lihat Detail
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Payment form --}}
                                <div class="mt-4 border-t pt-4">
                                    <form method="POST" action="{{ route('student.update_payment', $item->id) }}"
                                        enctype="multipart/form-data" class="grid gap-8">
                                        @csrf

                                        {{-- Ukuran Baju --}}
                                        <div>
                                            <label for="ukuran_baju" class="block text-sm font-medium text-gray-700">
                                                Ukuran Baju
                                                <span class="text-xs text-gray-500">(Harap pilih agar dapat diverifikasi
                                                    dalam proses pembayaran)</span>
                                            </label>
                                            <select name="ukuran_baju" id="ukuran_baju"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 text-gray-900 
                                                           focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-100 disabled:text-gray-500"
                                                @if ($item->status_pembayran) disabled @endif required>
                                                <option value="">-- Pilih Ukuran --</option>
                                                <option value="S"
                                                    {{ old('ukuran_baju', $item->ukuran_baju) == 'S' ? 'selected' : '' }}>S
                                                    (Small)</option>
                                                <option value="M"
                                                    {{ old('ukuran_baju', $item->ukuran_baju) == 'M' ? 'selected' : '' }}>M
                                                    (Medium)</option>
                                                <option value="L"
                                                    {{ old('ukuran_baju', $item->ukuran_baju) == 'L' ? 'selected' : '' }}>L
                                                    (Large)</option>
                                                <option value="XL"
                                                    {{ old('ukuran_baju', $item->ukuran_baju) == 'XL' ? 'selected' : '' }}>
                                                    XL (Extra Large)</option>
                                                <option value="XXL"
                                                    {{ old('ukuran_baju', $item->ukuran_baju) == 'XXL' ? 'selected' : '' }}>
                                                    XXL (Double Extra Large)</option>
                                            </select>
                                        </div>

                                        {{-- Bukti Pembayaran --}}
                                        <div>
                                            <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700">
                                                Bukti Pembayaran
                                            </label>
                                            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm px-3 py-2 text-gray-900 
                                                          focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-100 disabled:text-gray-500"
                                                @if ($item->status_pembayran) disabled @endif required>

                                            {{-- Download Link (if file exists) --}}
                                            @if ($item->bukti_pembayaran)
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/payment_proofs/' . $item->bukti_pembayaran) }}"
                                                        target="_blank" class="text-blue-600 hover:underline text-sm">
                                                        Lihat Bukti Pembayaran
                                                    </a>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Submit Button (Only if payment not submitted) --}}
                                        @if (!$item->status_pembayran)
                                            <div>
                                                <button type="submit"
                                                    class="w-full bg-color-primary-500 hover:bg-color-primary-600 text-white 
                                                               font-medium rounded-lg px-4 py-2">
                                                    Submit Pembayaran
                                                </button>
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-500">
                                                Pembayaran telah disubmit dan tidak dapat diubah.
                                            </div>
                                        @endif
                                    </form>
                                </div>


                                {{-- End Payment form --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
