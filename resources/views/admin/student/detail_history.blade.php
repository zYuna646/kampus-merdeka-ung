@extends('layout.admin')

@section('main')

<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
  <div class="flex col-span-12 mt-2 w-full" aria-label="Breadcrumb">
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
  <div class="flex flex-col col-span-12 rounded-lg shadow  min-h-96 w-full">
    <div class="w-full h-32 bg-color-primary-500 rounded-t-lg">
    </div>
    <div class="px-8 pb-8 bg-white w-full h-full rounded-b-lg relative">
      <div class="col-span-2 absolute top-0 -translate-y-8">
        <img src="/images/avatar/ung.png" alt="" class="w-16">
      </div>
      <div class="flex gap-x-2 items-center text-color-primary-500 mt-12 ">
        <span class=""><i class="fas fa-book text-sm"></i></span>
        <p class="text-sm font-semibold">Program Name</p>
      </div>
      <div class="">
        <h4 class="font-semibold text-lg">Nama Lokasi Contoh SDN 5 Telaga Jaya</h4>
      </div>
      
      <div class="flex flex-col gap-y-1 mt-4">
        <div class="inline-flex gap-x-2">
          <span class="text-sm text-slate-500">Kode Kegiatan: </span>
          <p class="text-sm">Kode</p>
        </div>
        <div class="inline-flex gap-x-2">
          <span class="text-sm text-slate-500">Tahun Akademik: </span>
          <p class="text-sm">2019</p>
        </div>
      </div>
      <hr class="w-full mt-4 mb-4">
      <div class="flex flex-col">
        <span class="text-sm text-slate-500">Berkas Dokumen: </span>
        <div class="flex items-center mt-2">
          <span
            class=" inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full ">
            <i class="fas fa-check"></i>
          </span>
          <div class="flex flex-col gap-y-2 max-w-[80%]">
            <p class="text-sm font-semibold ">Semua laporan mingguan sudah diterima</p>
          </div>
        </div>
      </div>
      <hr class="mt-4 mb-4">
      <div class="flex flex-col gap-y-2">
        <p class="font-semibold">Informasi</p>
        <p class="text-sm">Jika terjadi kendala dan butuh bantuan, hubungi mentor dan DPP (Dosen Pembimbing Program). Informasi kontak
          tersedia <a href="" class="font-semibold text-color-primary-500">di sini.</a> </p>
      </div>
    </div>
  </div>
</section>
@endsection