@extends('layout.auth')

@section('main')
<section class="h-screen flex flex-col relative">
  <div class="w-full h-full bg-color-primary-500 flex-[3] flex justify-end ">
    <div class="xl:inline-flex items-center justify-center px-12 gap-x-2 hidden max-w-screen-xl mx-auto">
      <div class="flex-[1] text-white  w-full flex flex-col gap-y-4">
        <div class="flex flex-col gap-y-2">
          <h1 class="font-bold text-4xl">Kampus Merdeka</h1>
          <span class="font-light">Universitas Negeri Gorontalo</span>
        </div>
        <p class="text-xs ">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque eum ipsam eveniet ducimus voluptates eos quo
          perferendis perspiciatis vitae delectus ab at dolorem earum blanditiis explicabo eaque, quidem ad cupiditate
          minima libero a nihil.
        </p>
      </div>
      <div class=" flex-[3]">
        <img src="/images/hero-image/Saly-1.png" alt="" class="w-96">
      </div>
    </div>
  </div>
  <div class="w-full flex-[1] hidden lg:block">

  </div>
  <div class="w-full h-screen absolute">
    <div class="max-w-screen-xl w-full h-full mx-auto flex items-center justify-center xl:justify-end px-8">
      <div class="xl:p-8 p-6 bg-white rounded-3xl max-w-md w-full flex flex-col gap-y-4 shadow-md">
        <div class="flex justify-between items-center">
          <span class="text-sm hidden lg:block">Selamat Datang!</span>
          <p class="text-sm">Belum Punya Akun? <a href="" class="text-color-primary-500">Daftar</a></p>
        </div>
        <h2 class="xl:text-5xl text-2xl font-bold text-gray-800">Masuk</h2>
        <form class="xl:mt-4" action="/login" method="POST">
          @csrf
          <div class="mb-5">
            <label for="username" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Masukan Nama
              Pengguna</label>
            <input type="text" name="username" id="username"
              class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-base text-xs "
              value="{{old('username')}}">
            @error('username')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="mb-2">
            <label for="password" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Masukan
              Password</label>
            <input type="password" name="password" id="password"
              class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-base text-xs "
              value="{{old('password')}}">
            @error('password')
            <div class="invalid-feedback text-red-400">
              {{$message}}
            </div>
            @enderror
          </div>
          <div class="w-full flex justify-end">
            <a href="" class="text-color-primary-500 text-sm">Lupa Password ?</a>
          </div>
          @if (session()->has('loginError'))
          <div class="flex justify-center">
            <div class="text-red-500">{{ session('loginError') }}</div>
          </div>
          @endif
          <div class="xl:mt-8 mt-4">

            <button type="submit"
              class="xl:px-5 xl:py-3 py-3 px-4 xl:text-base text-sm w-full font-medium text-center text-white bg-color-primary-500 rounded-md hover:bg-color-primary-600 focus:ring-4 focus:outline-none focus:ring-color-primary-300 ">Masuk</button>
          </div>
        </form>

      </div>
    </div>

  </div>
</section>
@endsection