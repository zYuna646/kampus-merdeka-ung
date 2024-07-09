@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">Master</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4 swiper-container swiper1 overflow-x-hidden">
    <div class="swiper-wrapper w-full">
      @foreach ($data['masters'] as $master)
      <div
        class="swiper-slide col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
        <div class="flex flex-col gap-y-1">
          <p class="text-sm font-semibold uppercase">{{ $master['label'] }}</p>
          <span class="text-4xl font-semibold ">{{ $master['count'] }}</span>
        </div>
        <i class="{{ $master['icon'] }} text-4xl"></i>
      </div>
      @endforeach
    </div>
  </div>

  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">Pengguna</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4 swiper-container swiper2 overflow-x-hidden">
    <div class="swiper-wrapper w-full">
      @foreach ($data['users'] as $user)
      <div
        class="swiper-slide col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
        <div class="flex flex-col gap-y-1">
          <p class="text-sm font-semibold uppercase">{{ $user['label'] }}</p>
          <span class="text-4xl font-semibold ">{{ $user['count'] }}</span>
        </div>
        <i class="{{ $user['icon'] }} text-4xl"></i>
      </div>
      @endforeach
    </div>
  </div>

  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">Berita</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4 swiper-container swiper3 overflow-x-hidden">
    <div class="swiper-wrapper w-full">
      @foreach ($data['news'] as $news)
      <div
        class="swiper-slide col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
        <div class="flex flex-col gap-y-1">
          <p class="text-sm font-semibold uppercase">{{ $news['label'] }}</p>
          <span class="text-4xl font-semibold ">{{ $news['count'] }}</span>
        </div>
        <i class="{{ $news['icon'] }} text-4xl"></i>
      </div>
      @endforeach
    </div>
  </div>

  <div class=" w-full flex items-end justify-center gap-x-4">
    <h1 class="font-semibold">MBKM</h1>
    <hr class="w-full">
  </div>
  <div class="grid grid-cols-12 gap-4 swiper-container swiper4 overflow-x-hidden">
    <div class="swiper-wrapper w-full">
      @foreach ($data['mbkm'] as $mbkm)
      <div
        class="swiper-slide col-span-12 lg:col-span-3 p-8 rounded-xl bg-white text-color-primary-500 flex justify-between items-center border border-slate-200 shadow-sm">
        <div class="flex flex-col gap-y-1">
          <p class="text-sm font-semibold uppercase">{{ $mbkm['label'] }}</p>
          <span class="text-4xl font-semibold ">{{ $mbkm['count'] }}</span>
        </div>
        <i class="{{ $mbkm['icon'] }} text-4xl"></i>
      </div>
      @endforeach
    </div>
  </div>

  <div class="p-8 rounded-xl bg-white">
    {!! $data['programchart']->container() !!}
  </div>

  <script src="{{ $data['programchart']->cdn() }}"></script>
  <script>
    var swiper1 = new Swiper('.swiper1', {
      pagination: '.swiper-pagination1',
      paginationClickable: true,
      spaceBetween: 12,
      slidesPerView: 1,
      breakpoints: {  
        480: {
          slidesPerView: 1,
          spaceBetween: 12,},
        640: {
          slidesPerView: 2,
          spaceBetween: 12,},
        768: {
          slidesPerView: 3,
          spaceBetween: 12,},
        1024: {
          slidesPerView: 4,
          spaceBetween: 12,},
      },
      freeMode: true,
      loop: true, 
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
    var swiper2 = new Swiper('.swiper2', {
      pagination: '.swiper-pagination2',
      paginationClickable: true,
      spaceBetween: 12,
      slidesPerView: 1,
      breakpoints: {  
        480: {
          slidesPerView: 1,
          spaceBetween: 12,},
        640: {
          slidesPerView: 2,
          spaceBetween: 12,},
        768: {
          slidesPerView: 3,
          spaceBetween: 12,},
        1024: {
          slidesPerView: 4,
          spaceBetween: 12,},
      },
      freeMode: true,
      loop: true, 
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
    var swiper3 = new Swiper('.swiper3', {
      pagination: '.swiper-pagination3',
      paginationClickable: true,
      spaceBetween: 12,
      slidesPerView: 1,
      breakpoints: {  
        480: {
          slidesPerView: 1,
          spaceBetween: 12,},
        640: {
          slidesPerView: 2,
          spaceBetween: 12,},
        768: {
          slidesPerView: 3,
          spaceBetween: 12,},
        1024: {
          slidesPerView: 4,
          spaceBetween: 12,},
      },
      freeMode: true,
      loop: true, 
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
    var swiper4 = new Swiper('.swiper4', {
      pagination: '.swiper-pagination4',
      paginationClickable: true,
      spaceBetween: 12,
      slidesPerView: 1,
      breakpoints: {  
        480: {
          slidesPerView: 1,
          spaceBetween: 12,},
        640: {
          slidesPerView: 2,
          spaceBetween: 12,},
        768: {
          slidesPerView: 3,
          spaceBetween: 12,},
        1024: {
          slidesPerView: 4,
          spaceBetween: 12,},
      },
      freeMode: true,
      loop: true, 
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
  </script>

  {{ $data['programchart']->script() }}
</section>
@endsection