@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
  <div class="col-span-12 grid grid-cols-12 gap-4">
    <div
      class="w-full h-full col-span-4 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-between">
      <div>
        <div href="#" class="w-full pt-8 pb-4 px-4 ">
          <img class="rounded-t-lg w-full brightness-50" src="/images/avatar/kampus_mengajar.png" alt="" />
        </div>
        <div class="p-6 flex flex-col gap-y-2">
          <h4 class="font-semibold text-xl">Kampus Mengajar</h4>
          <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, quod.</p>

        </div>
      </div>
      <div class="p-6">
        <button type="button"
          class="px-5 py-2.5 mt-2 w-full text-sm font-medium text-color-primary-500 inline-flex justify-center items-center bg-white border border-color-primary-500 rounded-lg text-center ">
          Cari Posisi
        </button>
      </div>
    </div>
    <div class="w-full col-span-4 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-start">
      <div href="#" class="w-full pt-8 pb-4 px-4 ">
        <img class="rounded-t-lg w-full brightness-50" src="/images/avatar/msib.png" alt="" />
      </div>
      <div class="p-6 flex flex-col gap-y-2">
        <h4 class="font-semibold text-xl">Magang MSIB</h4>
        <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, quod. Lorem ipsum dolor sit
          amet consectetur adipisicing e</p>

      </div>
      <div class="p-6">
        <button type="button"
          class="px-5 py-2.5 w-full text-sm font-medium text-color-primary-500 inline-flex justify-center items-center bg-white border border-color-primary-500 rounded-lg text-center ">
          Cari Posisi
        </button>
      </div>
    </div>
    <div class="w-full col-span-4 bg-white border border-gray-200 rounded-lg shadow flex flex-col justify-start">
      <div href="#" class="w-full pt-8 pb-4 px-4 ">
        <img class="rounded-t-lg w-full brightness-50" src="/images/avatar/msib.png" alt="" />
      </div>
      <div class="p-6 flex flex-col gap-y-2">
        <h4 class="font-semibold text-xl">Studi Independen</h4>
        <p class="text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni, quod. Lorem ipsum dolor sit
          amet consectetur adipisicing e</p>

      </div>
      <div class="p-6">
        <button type="button"
          class="px-5 py-2.5 w-full text-sm font-medium text-color-primary-500 inline-flex justify-center items-center bg-white border border-color-primary-500 rounded-lg text-center ">
          Cari Posisi
        </button>
      </div>
    </div>
  </div>
</section>
@endsection