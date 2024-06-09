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

  <div class="lg:col-span-4 col-span-12 w-full">
    <div class="p-6 bg-white grid grid-cols-12 gap-4 items-center rounded-xl shadow-sm border border-slate-200">
      <div class="relative col-span-3">
        <img src="/images/avatar/placeholder.jpg" alt="" class="w-20 rounded-full object-cover">
      </div>
      <div class="flex flex-col col-span-9">
        @auth
        <p class="font-semibold text-base uppercase">{{ Auth::user()->username }}</p>
        <span class="text-xs text-slate-500">{{Auth::user()->role->name}}</span>
        @endauth
        {{-- <span class="text-slate-500 text-sm">Universitas Negeri Gorontalo</span> --}}
      </div>
    </div>
    <div class="w-full bg-white border border-gray-200 rounded-lg shadow mt-4">
      <div class="p-6">
        <div class="grid grid-flow-row divide-y-[1px]">
          {{-- <button class="flex items-center gap-4 font-semibold pb-4 section-button" data-section="profile">
            <span><i class="fas fa-cog text-base"></i></span>
            <p class="text-sm">Pengaturan Profil</p>
          </button> --}}
          <button class="flex items-center gap-4 font-semibold py-4 section-button" data-section="account">
            <span><i class="fas fa-user text-base"></i></span>
            <p class="text-sm">Pengaturan Akun</p>
          </button>
          <button class="flex items-center gap-4 font-semibold py-4 section-button" data-section="password">
            <span><i class="fas fa-lock text-base"></i></span>
            <p class="text-sm">Ganti Sandi</p>
          </button>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
    {{-- <div id="profile"
      class="section-content bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2 hidden">
      <h3 class="py-4 text-lg font-semibold">Pengaturan Profil</h3>
      <hr>
      <div class="flex flex-col py-2">
        <div class="mb-4">
          <label for="nama lengkap" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Nama
            Lengkap</label>
          <input type="text" name="nama lengkap" id="nama lengkap" placeholder="nama lengkap"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
        <div class="mb-4">
          <label for="persentase" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Jenis
            Kelamin</label>
          <select
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            <option value="">L</option>
            <option value="">P</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="tempat lahir" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Tempat
            Lahir</label>
          <input type="text" name="tempat lahir" id="tempat lahir" placeholder="tempat lahir"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
        <div class="mb-4">
          <label for="tanggal lahir" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Tanggal
            Lahir</label>
          <input type="date" name="tanggal lahir" id="tanggal lahir" placeholder="tanggal lahir"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
        <div class="mb-4">
          <label for="agama" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">agama</label>
          <input type="text" name="agama" id="agama" placeholder="agama"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
      </div>
      <hr>
      <div class="py-2">
        <button type="button"
          class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
          Simpan Perubahan
        </button>
      </div>
    </div> --}}

    <div id="account"
      class="section-content bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2 hidden">
      <h3 class="py-4 text-lg font-semibold">Pengaturan Akun</h3>
      <hr>
      <div class="flex flex-col py-2">
        <div class="mb-4">
          <label for="username" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">username</label>
          <input type="text" name="username" id="username" placeholder="username" value={{Auth::user()->username}}
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          />
        </div>
        @auth
        @if (Auth::user()->role->slug === 'mahasiswa')
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Mahasiswa</label>
          <input type="text" name="name" id="name" placeholder="Masukan Nama Dosen"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
            value="">
        </div>
        <div class="mb-4">
          <label for="studi_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Program Studi</label>
          <select type="text" name="studi_id" id="studi_id" placeholder="Masukan Nama Program Studi"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            <option>Program Studi</option>
          </select>
        </div>
        @endif
        @endauth

        @auth
        @if (Auth::user()->role->slug === 'dosen')
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Dosen</label>
          <input type="text" name="name" id="name" placeholder="Masukan Nama Dosen"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
            value="">
        </div>
        <div class="mb-4">
          <label for="studi_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Program Studi</label>
          <select type="text" name="studi_id" id="studi_id" placeholder="Masukan Nama Program Studi"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
            <option>Program Studi</option>
          </select>
        </div>
        @endif
        @endauth
      </div>
      <hr>
      <div class="py-2">
        <x-button_md class="" color="primary">
          Simpan Perubahan
        </x-button_md>
      </div>
    </div>

    <div id="password"
      class="section-content bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-y-2 hidden">
      <h3 class="py-4 text-lg font-semibold">Ganti Sandi</h3>
      <hr>
      <div class="flex flex-col py-2">
        <div class="mb-4">
          <label for="password saat ini" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">password
            saat ini</label>
          <input type="password" name="password saat ini" id="password saat ini" placeholder="password saat ini"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
        <div class="mb-4">
          <label for="password baru" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">password
            baru</label>
          <input type="password" name="password baru" id="password baru" placeholder="password baru"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
        </div>
        <div class="mb-4">
          <label for="ulangi password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">ulangi
            password</label>
          <input type="password" name="ulangi password" id="ulangi password" placeholder="ulangi password"
            class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
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
      const buttons = document.querySelectorAll('.section-button');
      const sections = document.querySelectorAll('.section-content');

      buttons.forEach(button => {
        button.addEventListener('click', function() {
          const sectionToShow = this.getAttribute('data-section');

          sections.forEach(section => {
            if (section.id === sectionToShow) {
              section.classList.remove('hidden');
            } else {
              section.classList.add('hidden');
            }
          });
        });
      });

      const passwordFields = document.querySelectorAll('input[type="password"]');
      const checkbox = document.getElementById('vehicle1');

      checkbox.addEventListener('change', function() {
        passwordFields.forEach(field => {
          field.type = checkbox.checked ? 'text' : 'password';
        });
      });
    });
  </script>
</section>

@endsection