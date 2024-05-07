@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl min-h-screen mx-auto grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
  <div class="col-span-12 h- p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
    <div class="col-span-12">
      <div class="flex gap-x-2 items-center text-color-primary-500">
        <span class=""><i class="fas fa-book text-lg"></i></span>
        <p class="text-lg font-semibold">Kampus Mengajar</p>
      </div>
    </div>
    <div class="mt-4 col-span-12 flex gap-x-4">
      <label for="username" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white sr-only">Masukan Nama
        Pengguna</label>
      <input type="text" id="username" placeholder="Cari Lokasi, Nama Program, Dll"
        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs ">
      <button type="button"
        class="px-5 py-2.5 w-fit text-sm font-medium text-white inline-flex items-center bg-color-primary-500 rounded-lg text-center ">
        <span class=""><i class="fas fa-search text-lg "></i></span>
      </button>
    </div>
  </div>
  <div class="col-span-4">
    <p class="text-sm mb-2 italic">Total Posisi : <span>80</span></p>
    <div class="max-h-[42rem] overflow-y-auto flex flex-col gap-y-2">
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
        </div>
      </div>
      <div
        class="bg-white p-6 rounded-xl w-full flex gap-x-6 border border-slate-100 shadow-sm hover:border-color-primary-500 hover:bg-slate-50 ">
        <div class="w-12">
          <img src="/images/avatar/mitra.png" alt="">
        </div>
        <div>
          <p class="font-semibold text-sm">Tenaga Pengajar</p>
          <p class="text-sm">SDN 6 Telaga Biru Kab. Gorontalo</p>
          <div class="flex gap-x-2 items-center text-color-primary-500">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">Kampus Mengajar</p>
          </div>
          <span class="text-sm text-slate-500">3 Bulan</span>
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
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloremque quae iure est saepe cum quod quisquam,
          iste dolore obcaecati accusamus earum laborum magni incidunt id voluptas consequuntur explicabo corrupti
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
      </div>
    </div>
    <div class="grid grid-cols-12 p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
      <div class="col-span-12 flex flex-col gap-y-2">
        <h4 class="text-xl font-semibold">Lokasi Kegiatan</h4>
        <p class="text-sm">Kamu akan mengikuti kegiatan dari tanggal 14 Agu - 31 Des 2023.</p>
      </div>
    </div>

    {{-- <div class="flex items-start justify-center w-full p-10 bg-white rounded-xl border border-slate-200 shadow-sm">
      <div class="flex flex-col gap-y-2 items-center justify-center">
        <img src="/images/avatar/Search-for-Ideas.png" alt="" class="w-44">
        <p class="text-lg font-semibold">Belum Ada Program</p>
        <p class="text-sm">Saat ini program belum tersedia</p>
        <button type="button"
          class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
          Daftar Kegiatan
        </button>
      </div>
    </div> --}}
  </div>
</section>
@endsection