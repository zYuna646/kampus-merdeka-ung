@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">Program</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4">
    <div class="w-full col-span-4 bg-white border border-gray-200 hover:bg-gray-100 hover:border-color-primary-500 cursor-pointer transition-all duration-300 rounded-lg shadow mt-4">
      <a href="#" class="w-full">
        <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
      </a>
      <div class="p-6">
        <div class="">
          <div class="flex justify-between items-center">
            <div class="flex gap-x-2 items-center text-color-primary-500">
              <span class=""><i class="fas fa-book text-sm"></i></span>
              <p class="text-sm font-semibold">Kampus Mengajar</p>
            </div>
            <span>
              <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
            </span>
          </div>
          <p class="text-base mt-1">
            SDN 6 Telaga Biru Kota Gorontalo
          </p>
          <p class="text-sm mt-1 text-slate-500">
            Semester Ganjil 2023/2024
          </p>
          <div class="mt-3 flex flex-col gap-y-1">
            <span class="text-sm mt-1 font-semibold">
              MITRA/Guru Pamong :
            </span>
            <p class="uppercase text-sm">
              Suryato Bilal Bil Halal
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full col-span-4 bg-white border border-gray-200 hover:bg-gray-100 hover:border-color-primary-500 cursor-pointer transition-all duration-300 rounded-lg shadow mt-4">
      <a href="#" class="w-full">
        <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
      </a>
      <div class="p-6">
        <div class="">
          <div class="flex justify-between items-center">
            <div class="flex gap-x-2 items-center text-color-primary-500">
              <span class=""><i class="fas fa-book text-sm"></i></span>
              <p class="text-sm font-semibold">Kampus Mengajar</p>
            </div>
            <span>
              <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
            </span>
          </div>
          <p class="text-base mt-1">
            SDN 6 Telaga Biru Kota Gorontalo
          </p>
          <p class="text-sm mt-1 text-slate-500">
            Semester Ganjil 2023/2024
          </p>
          <div class="mt-3 flex flex-col gap-y-1">
            <span class="text-sm mt-1 font-semibold">
              MITRA/Guru Pamong :
            </span>
            <p class="uppercase text-sm">
              Suryato Bilal Bil Halal
            </p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection