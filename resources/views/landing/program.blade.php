@extends('layout.landing')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
  <div class="col-span-12 lg:col-span-8 px-2">
    <div>
      <h2 class="text-2xl font-semibold text-color-primary-500 px-4">
        Semua Perogram
      </h2>
    </div>
    <div class="flex items-center justify-center gap-x-4 px-4 mt-6 mb-2">
      <input name="dosen_id" id="lokasi" placeholder="Cari Program"
        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
      <button type="button" id="add_repeater"
        class="text-white w-fit h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-4 col-span-12">
        <span><i class="fas fa-search"></i></span>
      </button>
    </div>
    <div class="grid grid-flow-row divide-y-2">
      <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
        <div class="col-span-12 flex flex-col justify-between py-2 gap-y-2">
          <div class="col-span-2 w-16 h-16">
            <img src="/images/avatar/ung.png" alt="" class="w-16">
          </div>
          <div class="flex gap-x-2 items-center text-color-primary-500 mt-2">
            <span class=""><i class="fas fa-book text-sm"></i></span>
            <p class="text-sm font-semibold">
              Program Name
            </p>
          </div>
          <div class="flex flex-col gap-y-4">
            <a href="" class="font-semibold lg:text-lg news-title">Lorem ipsum dolor, sit amet consectetur adipisicing
              elit.
              Magnam,
              ut.</a>
            <p class="text-xs lg:text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus incidunt
              nemo
              laborum possimus eius
              maxime.</p>
          </div>
          <div>
            <x-button_md color="primary" class="w-fit">
              Daftar
            </x-button_md>
          </div>
        </div>
      </div>
    </div>
    <div class="px-4">

    </div>

  </div>
  <div class="col-span-12 lg:col-span-4 flex flex-col gap-y-4 px-2">
    <div>
      <h2 class="font-semibold text-lg px-4">
        Program Terbaru
      </h2>
      <div class="grid grid-flow-row divide-y-[1px]">
        <div class=" bg-white divide-y-2 grid grid-cols-12 gap-4 ">
          <div class="col-span-12 flex flex-col gap-y-2 p-4">
            <div class="flex gap-x-2 items-center text-color-primary-500">
              <span class=""><i class="fas fa-book text-sm"></i></span>
              <p class="text-sm font-semibold">
                Program Name
              </p>
            </div>
            <p class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing
              elit.</p>
            <p class="text-sm text-slate-500">14 Juni 2023</p>
            <x-button_md color="primary" class="mt-4 w-fit">
              Daftar
            </x-button_md>
          </div>
          <div class="col-span-12 flex flex-col gap-y-2 p-4">
            <div class="flex gap-x-2 items-center text-color-primary-500">
              <span class=""><i class="fas fa-book text-sm"></i></span>
              <p class="text-sm font-semibold">
                Program Name
              </p>
            </div>
            <p class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing
              elit.</p>
            <p class="text-sm text-slate-500">14 Juni 2023</p>
            <x-button_md color="primary" class="mt-4 w-fit">
              Daftar
            </x-button_md>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection