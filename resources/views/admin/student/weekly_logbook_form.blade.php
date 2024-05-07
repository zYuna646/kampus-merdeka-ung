@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg min-h-screen mx-auto flex justify-center items-center py-44 px-4 lg:px-12 gap-4">
  <div class="w-full p-10 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col">
    <div class="w-full flex flex-col items-center">
      <p class="font-semibold text-lg">Laporan Mingguan</p>
      <p class="text-sm text-slate-500">Minggu Ke-2, 24 Agu - 7 Sep 2024</p>
    </div>
    <div class="mt-12">
      <form action="" class=" w-full">
        <div class="mb-4">
          <label for="deskripsi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            Apa yang kamu pelajari minggu ini
          </label>
          <textarea id="deskripsi" placeholder="Deskripsi Kegiatan" rows="8"
            class="block w-full h-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs ">
          </textarea>
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