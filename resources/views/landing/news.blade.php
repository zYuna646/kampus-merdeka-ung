@extends('layout.landing')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
  <div class="col-span-12 lg:col-span-8 px-2">
    <h2 class="text-2xl font-semibold text-color-primary-500 px-4">
      Semua Berita
    </h2>
    <div class="grid grid-flow-row">
      <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
        <div class="col-span-12 lg:col-span-6">
          <img src="/images/hero-image/image.png" alt="" class="rounded-lg w-full object-cover lg:h-56 h-36">
        </div>
        <div class="col-span-12 lg:col-span-6 flex flex-col justify-between py-2 gap-y-4">
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
            <p class="text-sm text-slate-500">Feb 4, 2024</p>
            <a href="" class="uppercase font-semibold text-sm text-color-primary-500">communication</a>
          </div>
        </div>
      </div>
      <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
        <div class="col-span-12 lg:col-span-6">
          <img src="/images/hero-image/image.png" alt="" class="rounded-lg w-full object-cover lg:h-56 h-36">
        </div>
        <div class="col-span-12 lg:col-span-6 flex flex-col justify-between py-2 gap-y-4">
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
            <p class="text-sm text-slate-500">Feb 4, 2024</p>
            <a href="" class="uppercase font-semibold text-sm text-color-primary-500">communication</a>
          </div>
        </div>
      </div>
      <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
        <div class="col-span-12 lg:col-span-6">
          <img src="/images/hero-image/image.png" alt="" class="rounded-lg w-full object-cover lg:h-56 h-36">
        </div>
        <div class="col-span-12 lg:col-span-6 flex flex-col justify-between py-2 gap-y-4">
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
            <p class="text-sm text-slate-500">Feb 4, 2024</p>
            <a href="" class="uppercase font-semibold text-sm text-color-primary-500">communication</a>
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
        Berita Terpopuler
      </h2>
      <div class="grid grid-flow-row divide-y-[1px]">
        <div class="p-4 bg-white  grid grid-cols-12 gap-4">
          <div class="col-span-6 rounded-lg">
            <img src="/images/hero-image/image.png" alt="" class="rounded-md w-full h-24 object-cover">
          </div>
          <div class="col-span-6 flex flex-col gap-y-2">
            <a href="" class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing
              elit.</a>
            <p class="text-sm text-slate-500">14 Juni 2023</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="isolated fixed z-20 bottom-6 right-6">
  <button class="p-2 px-3.5 w-12 h-12 rounded-full bg-color-primary-500 text-white" id="scroll-top">
    <span><i class="fas fa-arrow-up"></i></span>
  </button>
</div>

@endsection