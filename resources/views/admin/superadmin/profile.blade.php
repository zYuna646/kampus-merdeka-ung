@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  <div class="grid grid-cols-12 gap-4">
    <div class="col-span-4 w-full flex flex-col gap-y-2">
      <div class="p-6 bg-white grid grid-cols-12 gap-4 items-center rounded-xl shadow-sm border border-slate-200">
        <div class="relative col-span-3">
          <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full object-cover">
          <button
            class="absolute right-0 bottom-0 inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-white hover:bg-slate-100 shadow-md border border-slate-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
            <i class="fas fa-pencil-alt text-xs"></i>
          </button>
        </div>
        <div class="flex flex-col col-span-8">
          @auth
          <p class="font-semibold text-base uppercase">Mohamad Rafiq Daud</p>
          <span class="text-xs text-slate-500">Role</span>
          @endauth
          <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span>
        </div>
      </div>
      <div class="p-6  bg-white flex flex-col gap-4  rounded-xl shadow-sm border border-slate-200">
        <button class="inline-flex items-center gap-x-2 col-span-12">
          <div>
            <span>
              <i class="fas fa-user-cog"></i>
            </span>
          </div>
          <p class="text-sm font-semibold">Data Akun</p>
        </button>
        <hr class="w-full">
        <button class="inline-flex items-center gap-x-2 col-span-12">
          <div>
            <span>
              <i class="fas fa-lock"></i>
            </span>
          </div>
          <p class="text-sm font-semibold">Ganti Password</p>
        </button>
      </div>
    </div>
    <div class="col-span-8 w-full">
      {{-- <div class="bg-white flex flex-col rounded-xl shadow-sm border border-slate-200">
        <p class="p-6 font-semibold">Edit Data Akun</p>
        <hr class="w-full">
        <div class="p-6 flex flex-col gap-y-2">
          <p class="font-semibold">Informasi Data Diri</p>
          <form method="POST">
            @csrf
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Nama Lengkap</label>
              <input type="text" name="name" id="nama" placeholder="Masukan Nama Fakultas"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <x-button_md color="primary" class="w-fit" type="submit">
              Perbarui
            </x-button_md>
          </form>
        </div>
        <hr class="w-full">
        <div class="p-6 flex flex-col gap-y-2">
          <p class="font-semibold">Data Akun</p>
          <form method="POST">
            @csrf
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Username</label>
              <input type="text" name="name" id="nama" placeholder="Masukan Nama Fakultas"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Email</label>
              <input type="text" name="name" id="nama" placeholder="Masukan Nama Fakultas"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <x-button_md color="primary" class="w-fit" type="submit">
              Perbarui
            </x-button_md>
          </form>
        </div>
      </div> --}}
      <div class="bg-white flex flex-col rounded-xl shadow-sm border border-slate-200">
        <p class="p-6 font-semibold">Ganti Password</p>
        <hr class="w-full">
        <div class="p-6 flex flex-col gap-y-2">
          <p class="font-semibold">Ubah Password dengan Password baru</p>
          <form method="POST">
            @csrf
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Password Sekarang</label>
              <input type="passsword" name="name" id="nama" placeholder="Password Sekrang"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Password Baru</label>
              <input type="paassword" name="name" id="nama" placeholder="Password Baru"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <div class="mb-4">
              <label for="nama" class="block text-sm text-gray-700 mb-2">Masukan Ulang Password Baru</label>
              <input type="paassword" name="name" id="nama" placeholder="Masukan Ulang Password Baru"
                class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            </div>
            <x-button_md color="primary" class="w-fit" type="submit">
              Perbarui
            </x-button_md>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection