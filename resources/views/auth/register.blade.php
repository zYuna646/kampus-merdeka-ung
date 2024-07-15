@extends('layout.auth')

@section('main')
<section class="h-screen flex flex-col relative justify-center">
  <div class="w-full h-full bg-color-primary-500 flex-[3] flex justify-end ">
    {{-- <div class="xl:inline-flex items-center justify-center px-12 gap-x-2 hidden max-w-screen-xl mx-auto">
      <div class="flex-[1] text-white  w-full flex flex-col gap-y-4">
        <div class="flex flex-col gap-y-2">
          <h1 class="font-bold text-4xl">Kampus Merdeka</h1>
          <span class="font-light">Universitas Negeri Gorontalo</span>
        </div>
        <p class="text-xs ">
          Pantau aktivitas mahasiswa MBKM di UNG dengan mudah! Dapatkan solusi terpadu untuk transparansi dan
          kesuksesan program MBKM dalam satu platform resmi UNG. Pastikan kemajuan dan evaluasi kegiatan dengan
          aplikasi monitoring inovatif kami.
        </p>
      </div>
      <div class=" flex-[3]">
        <img src="/images/hero-image/Saly-1.png" alt="" class="w-96">
      </div>
    </div> --}}
  </div>
  <div class="w-full flex-[1] hidden lg:block">

  </div>
  <div class="w-full h-screen absolute lg:pt-8">
    <div class="w-full h-full mx-auto flex items-center justify-center px-8">
      <div
        class="p-8 bg-white rounded-3xl max-w-screen-md w-full flex flex-col gap-y-4 shadow-md border border-slate-200">
        <div class="flex justify-between items-center">
          {{-- <span class="text-sm hidden lg:block">Selamat Datang!</span> --}}
          {{-- <p class="text-sm">Belum Punya Akun? <a href="" class="text-color-primary-500">Daftar</a></p> --}}
        </div>
        <h2 class="xl:text-3xl text-2xl font-bold text-gray-800">Daftar</h2>
        <form class="xl:mt-2 grid grid-cols-12 gap-4" action="/login" method="POST">
          @csrf
          <div class="mb-2 col-span-6">
            <label for="nim" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Masukan NIM</label>
            <input type="text" name="nim" id="nim" placeholder="NIM"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('nim')}}">
            @error('nim')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="mb-2 col-span-6">
            <label for="nama" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Masukan
              Nama Lengkap</label>
            <input type="text" name="nama" id="nama" placeholder="Nama Lengkap"
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('nama')}}">
            @error('nama')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <hr class="col-span-12">
          <div class="mb-2 col-span-4">
            <label for="fakultas" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Fakultas</label>
            <select type="text" name="fakultas" id="fakultas" placeholder="fakultas "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('fakultas')}}">
              <option value="">Pilih Fakultas</option>
            </select>
            @error('fakultas')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="mb-2 col-span-4">
            <label for="jurusan" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Jurusan</label>
            <select type="text" name="jurusan" id="jurusan" placeholder="jurusan "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('jurusan')}}">
              <option value="">Pilih jurusan</option>
            </select>
            @error('jurusan')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="mb-2 col-span-4">
            <label for="prodi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Pilih
              Prodi</label>
            <select type="text" name="prodi" id="prodi" placeholder="prodi "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('prodi')}}">
              <option value="">Pilih prodi</option>
            </select>
            @error('prodi')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <hr class="col-span-12">
          <div class="mb-2 col-span-6">
            <label for="username" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Username</label>
            <input type="text" name="username" id="username" placeholder="username "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('username')}}" />
            @error('username')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="mb-2 col-span-6">
            <label for="password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Passowrd</label>
            <input type="password" name="password" id="password" placeholder="password "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('password')}}" />
            @error('password')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <hr class="col-span-12">
          <div class="mb-2 col-span-6">
            <label for="password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Passowrd</label>
            <input type="password" name="password" id="password" placeholder="password "
              class="block w-full p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs "
              value="{{old('password')}}" />
            @error('password')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          {{-- <div class="w-full flex justify-end">
            <a href="" class="text-color-primary-500 text-sm">Lupa Password ?</a>
          </div> --}}
          @if (session()->has('loginError'))
          <div class="flex justify-center">
            <div class="text-red-500">{{ session('loginError') }}</div>
          </div>
          @endif
          <x-button_md class="w-fit col-span-12" color="primary">
            Daftar
          </x-button_md>
        </form>

      </div>
    </div>

  </div>
</section>
@endsection