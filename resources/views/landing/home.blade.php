@extends('layout.landing')

@section('main')
<section class="h-screen w-full relative flex items-center justify-center">
  <div class="swiper h-full">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper h-full">
      <!-- Slides -->
      <div class="swiper-slide h-full ">
        <div class="h-full">
          <img src="/images/hero-image/rektorat.jpg" alt="" class="object-cover w-full h-full brightness-[.2]">
        </div>
      </div>
      <div class="swiper-slide h-full">
        <div class="h-full">
          <img src="/images/hero-image/rektorat2.jpg" alt="" class="object-cover w-full h-full brightness-[.2]">
        </div>
      </div>
    </div>
  </div>
  <div class="flex flex-col gap-y-2 absolute z-10 text-white w-full max-w-screen-xl px-8">
    <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold">Kampus <span class="text-color-primary-500">Merdeka</span>
    </h1>
    <p class="text-lg">Universitas Negeri Gorontalo</p>
    <p class="text-sm max-w-sm">
      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Excepturi recusandae dolore illum minima suscipit, iste
      amet atque omnis illo saepe.
    </p>
  </div>
</section>
<section class=" min-h-screen bg-white flex items-center justify-center flex-wrap">
  <div class="max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
    <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
      <img src="/images/avatar/km_colored.png" alt="" class="rounded-xl w-4/6">
      
    </div>
    <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
      <h2 class="text-xl lg:text-4xl font-bold">Kampus <span class="text-color-primary-500">Merdeka</span></h2>
      <p class="text-xs lg:text-xl font-semibold">Program persiapan karier yang komprehensif untuk mempersiapkan
        generasi terbaik
        Indonesia</p>
      <p class="text-xs lg:text-sm max-w-lg">Kampus Merdeka adalah bagian dari kebijakan Merdeka Belajar oleh
        Kementerian Pendidikan,
        Kebudayaan, Riset, dan
        Teknologi (Kemendikbudristek) yang memberikan seluruh mahasiswa
        <span class="font-semibold text-color-primary-500">
          kesempatan untuk mengasah kemampuan sesuai
          bakat
          dan minat
        </span>
        dengan
        <span class="font-semibold text-color-primary-500">
          terjun langsung ke dunia kerja
        </span>
        sebagai
        <span class="font-semibold text-color-primary-500">
          langkah persiapan
          karier.
        </span>
      </p>
    </div>
  </div>
</section>
<section>

</section>
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-16 lg:py-24">
  <div class="col-span-12 lg:col-span-8 px-2">
    <h2 class="text-2xl font-semibold text-color-primary-500 px-4">
      Berita Terbaru
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
    </div>
    <div class="px-4">
      <button type="submit"
        class="text-white w-full lg:w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
        Lihat Semua Berita
      </button>
    </div>

  </div>
  <div class="col-span-12 lg:col-span-4 flex flex-col gap-y-4 px-2">
    <div>
      <h2 class="font-semibold text-lg px-4">
        MBKM
      </h2>
      <div class="flex flex-col p-4">
        <div
          class="p-4 bg-color-primary-500 text-white flex items-center justify-center text-sm rounded-tl-md rounded-tr-md">
          Pendaftaran Peserta MBKM
        </div>
        <div class="border border-slate-200 min-h-52 flex items-center justify-center">
          InfoGraph here
        </div>
      </div>
    </div>
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
            <a href="" class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</a>
            <p class="text-sm text-slate-500">14 Juni 2023</p>
          </div>
        </div>
      </div>
    </div>
    <div>
      <h2 class="font-semibold text-lg px-4">
        Download
      </h2>
      <div class="p-4 grid grid-flow-row divide-y-[1px]">
        <div class="p-3 bg-white grid grid-cols-12 gap-4">
          <p class="text-sm col-span-10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates aliquam,
          </p>
          <button class="col-span-2 hover:text-slate-500 transition-colors duration-300">
            <span><i class="fas fa-download"></i></span>
          </button>
        </div>
        <div class="p-3 bg-white grid grid-cols-12 gap-4">
          <p class="text-sm col-span-10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates aliquam,
          </p>
          <button class="col-span-2 hover:text-slate-500 transition-colors duration-300">
            <span><i class="fas fa-download"></i></span>
          </button>
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
<script>
  const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
  });

  document.getElementById('scroll-top').addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Menggulir dengan animasi halus
    });
  });
  
  function truncate(text, maxLength) {
    if (text.length > maxLength) {
      return text.substring(0, maxLength - 3) + '...';
    }
    return text;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const maxLength = 60; // Anda bisa mengatur panjang maksimum sesuai kebutuhan
    const titles = document.querySelectorAll('.news-title');

    titles.forEach(title => {
      title.textContent = truncate(title.textContent, maxLength);
    });
  });

</script>
@endsection