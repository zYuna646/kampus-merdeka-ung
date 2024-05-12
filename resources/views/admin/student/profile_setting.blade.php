@extends('layout.admin')

@section('main')

<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
  <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
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

  <div class="lg:col-span-4 col-span-12  w-full ">
    <div class="p-6 bg-white flex gap-4 items-center rounded-xl shadow-sm border border-slate-200">
      <div class=" relative w-fit">
        <img src="/images/avatar/avatar.jpg" alt="" class="w-20 rounded-full object-cover">
        <button
          class="absolute right-0 bottom-0 inline-flex items-center justify-center w-6 h-6 me-2 text-sm font-semibold text-gray-800 bg-white hover:bg-slate-100 shadow-md border border-slate-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
          <i class="fas fa-pencil-alt text-xs"></i>
        </button>
      </div>
      <div class="flex flex-col ">
        <p class="font-semibold text-base uppercase">Lorem ipsum dolor sit.</p>
        <span class="text-xs text-slate-500">Lorem ipsum dolor sit amet consectetur.</span>
        <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span>
      </div>
    </div>
    <div class="w-full bg-white border border-gray-200 rounded-lg shadow mt-4">
      <div class="p-6">
        <div class="grid grid-flow-row divide-y-[1px]">

          {{-- <div class="flex items-center gap-4 font-semibold py-4">
            <span class=""><i class="fas fa-clipboard-check text-xl"></i></span>
            <p class="text-sm">Log Book Mingguan</p>
          </div> --}}
          <div class="flex items-center gap-4 font-semibold pb-4">
            <span class=""><i class="fas fa-cog text-base"></i></span>
            <p class="text-sm">Pengaturan Profil</p>
          </div>
          <div class="flex items-center gap-4 font-semibold py-4">
            <span class=""><i class="fas fa-user text-base"></i></span>
            <p class="text-sm">Pengaturan Akun</p>
          </div>
          <div class="flex items-center gap-4 font-semibold py-4">
            <span class=""><i class="fas fa-lock text-base"></i></span>
            <p class="text-sm">Ganti Sandi</p>
          </div>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>

        </div>
      </div>
    </div>

  </div>

  <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2">
      <h3 class="py-4 text-lg font-semibold">Pengaturan Profil</h3>
      <hr>
      <div class="flex flex-col py-2">
        <div class="mb-4">
          <label for="nama lengkap" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            Nama Lengkap
          </label>
          <input type="text" name="nama lengkap" id="nama lengkap" placeholder="nama lengkap"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="persentase" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            Jenis Kelamin
          </label>
          <select
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs ">
            <option value="">L</option>
            <option value="">P</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="tempat lahir" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            Tempat Lahir
          </label>
          <input type="text" name="tempat lahir" id="tempat lahir" placeholder="tempat lahir"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="tanggal lahir" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            Tanggal Lahir
          </label>
          <input type="date" name="tanggal lahir" id="tanggal lahir" placeholder="tanggal lahir"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="agama" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            agama
          </label>
          <input type="text" name="agama" id="agama" placeholder="agama"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
      </div>
      <hr>
      <div class="py-2">
        <button type="button"
          class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
          Simpan Perubahan
        </button>
      </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2">
      <h3 class="py-4 text-lg font-semibold">Pengaturan Akun</h3>
      <hr>
      <div class="flex flex-col py-2">
        <div class="mb-4">
          <label for="username" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            username
          </label>
          <input type="text" name="username" id="username" placeholder="username"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="email" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            email
          </label>
          <input type="email" name="email" id="email" placeholder="email"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
      </div>
      <hr>
      <div class="py-2">
        <button type="button"
          class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
          Simpan Perubahan
        </button>
      </div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2">
      <h3 class="py-4 text-lg font-semibold">Ganti Sandi</h3>
      <hr>
      <div class="flex flex-col py-2">

        <div class="mb-4">
          <label for="password saat ini" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            password saat ini
          </label>
          <input type="password" name="password saat ini" id="password saat ini" placeholder="password saat ini"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="password baru" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            password baru
          </label>
          <input type="password" name="password baru" id="password baru" placeholder="password baru"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div class="mb-4">
          <label for="ulangi password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
            ulangi password
          </label>
          <input type="password" name="ulangi password" id="ulangi password" placeholder="ulangi password"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs " />
        </div>
        <div>
          <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
          <label for="vehicle1">Lihat Password</label><br>
        </div>
      </div>
      <hr>
      <div class="py-2">
        <button type="button"
          class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
          Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const passwordFields = document.querySelectorAll('input[type="password"]');
      const checkbox = document.getElementById('vehicle1');
  
      checkbox.addEventListener('change', function() {
        passwordFields.forEach(function(field) {
          if (checkbox.checked) {
            field.type = 'text';
          } else {
            field.type = 'password';
          }
        });
      });
    });
  </script>
</section>

@endsection