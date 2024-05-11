@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 p-32 px-4 lg:px-12 gap-4">
  <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
      <li class="inline-flex items-center">
        <a
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
  <div class="col-span-12 w-full">
    <div class="p-6 bg-white border border-slate-200 shadow-sm rounded-xl mt-4 flex flex-col gap-y-4">
      <h1 class="text-lg font-semibold">Cari Program</h1>
      <div>
        <form action="" class="w-full grid grid-cols-7 gap-4">
          <div class="relative mb-2 col-span-12 lg:col-span-3">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
              <span>
                <i class="fas fa-user text-lg text-slate-500"></i>
              </span>
            </div>
            <input type="text" id="input-group-1"
              class="bg-gray-50 border block border-gray-300 text-gray-900 xl:text-sm text-xs rounded-lg w-full ps-12 p-4 "
              placeholder="DPL">
          </div>
          <div class="relative mb-2 col-span-12 lg:col-span-3">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
              <span>
                <i class="fas fa-map-marker-alt text-lg text-slate-500"></i>
              </span>
            </div>
            <input type="text" id="input-group-1"
              class="bg-gray-50 border block border-gray-300 text-gray-900 xl:text-sm text-xs rounded-lg w-full ps-10 p-4 "
              placeholder="Lokasi">
          </div>
          <div class="col-span-3 lg:col-span-1">
            <button
              class="text-white w-full h-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-base px-5 py-3.5 me-2">
              Cari
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="lg:col-span-4 col-span-12  w-full ">
    <p class="text-sm italic my-4">Total Program : <span>80</span></p>
    <div class="w-full max-h-[42rem] overflow-y-auto flex flex-col gap-y-4">
      <div
        class="w-full bg-white border border-gray-200 hover:border-color-primary-500 hover:bg-slate-100 transition-colors duration-300 rounded-lg shadow">
        <a class="w-full">
          <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
        </a>
        <div class="p-6">
          <div class="">
            <div class="flex justify-between items-center">
              <div class="flex gap-x-2 items-center text-color-primary-500">
                <span class=""><i class="fas fa-book text-sm"></i>
                  asdasd</span>
                <p class="text-sm font-semibold">{{-- Masukkan informasi yang sesuai di sini --}}</p>
              </div>
              <span>
                <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
              </span>
            </div>
            <p class="text-base mt-1">

            </p>
            <p class="text-sm mt-1 text-slate-500">
              asdasd
            </p>
          </div>
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
      <div class="flex items-center col-span-12 mt-2 mb-2">
        <span
          class="inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-white bg-color-success-500 rounded-full ">
          <i class="fas fa-check"></i>
        </span>
        <p class="text-sm font-semibold">17 Mahasiswa Terdaftar</p>
      </div>
      <div class="col-span-12 mt-2 flex flex-col gap-y-2">
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
          Detail Program
        </button>
      </div>
    </div>
  </div>
</section>
@endsection