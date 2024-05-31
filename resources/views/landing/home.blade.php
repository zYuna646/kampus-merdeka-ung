@extends('layout.landing')

@section('main')
<section class="h-screen w-full relative flex items-center justify-center">
  <div class="h-full w-full brightness-50 bg-cover">
    <img src="/images/hero-image/rektorat2.jpg" alt="" class="w-full h-full object-cover brightness-50">
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
<section class="min-h-screen w-full max-w-screen-xl mx-auto  bg-white flex items-center justify-center flex-wrap">
  <div class="swiper h-full">
    <div class="swiper-wrapper h-full">
      <div class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
        <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
          <img src="/images/avatar/iisma_hero.png" alt="" class="rounded-xl w-4/6">
        </div>
        <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
          <h2 class="text-xl lg:text-4xl font-bold">IISMA<span class="text-color-primary-500"></span></h2>
          <p class="text-xs lg:text-xl font-semibold">Perluas wawasan dan koneksi melalui Pertukaran Mahasiswa secara
            Internasional</p>
          <p class="text-xs lg:text-sm max-w-lg">Indonesian International Student Mobility Awards (IISMA) is a
            scholarship scheme by the Ministry of Education, Culture, Research, and Technology of the Republic of
            Indonesia to fund Indonesian students for a one semester-mobility program at top universities and reputable
            industries overseas.
          </p>
        </div>
      </div>
      <div class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
        <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
          <img src="/images/avatar/kampus_mengajar_hero.png" alt="" class="rounded-xl w-4/6">
        </div>
        <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
          <h2 class="text-xl lg:text-4xl font-bold">Kampus <span class="text-color-primary-500">Mengajar</span></h2>
          <p class="text-xs lg:text-xl font-semibold">Bantu tingkatkan kualitas
            pengajaran pendidikan
            dasar melalui Kampus Mengajar</p>
          <p class="text-xs lg:text-sm max-w-lg">
            Kampus Mengajar merupakan kanal pembelajaran yang memberikan kesempatan kepada mahasiswa untuk belajar di
            luar kampus selama satu semester guna melatih kemampuan menyelesaikan permasalahan yang kompleks dengan
            menjadi mitra guru untuk berinovasi dalam pembelajaran, pengembangan strategi, dan model pembelajaran yang
            kreatif, inovatif, dan menyenangkan.
          </p>
        </div>
      </div>
      <div class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
        <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
          <img src="/images/avatar/msib_hero.png" alt="" class="rounded-xl w-4/6">
        </div>
        <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
          <h2 class="text-xl lg:text-4xl font-bold">Magang <span class="text-color-primary-500">MSIB</span></h2>
          <p class="text-xs lg:text-xl font-semibold">Rasakan pengalaman
            dunia kerja dengan terjun
            langsung melalui Magang MSIB</p>
          <p class="text-xs lg:text-sm max-w-lg">Magang MSIB adalah program magang yang diawasi langsung oleh
            Kemendikbudristek selama 1 (satu) semester untuk mendapatkan pengalaman kerja dan pengetahuan tentang
            praktik terbaik dari industri yang kamu minati!
          </p>
        </div>
      </div>
      <div class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
        <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
          <img src="/images/avatar/msib_hero.png" alt="" class="rounded-xl w-4/6">
        </div>
        <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
          <h2 class="text-xl lg:text-4xl font-bold">Studi <span class="text-color-primary-500">Independen</span></h2>
          <p class="text-xs lg:text-xl font-semibold">Riset kolaboratif bersama perusahaan ternama
            melalui Studi Independen</p>
          <p class="text-xs lg:text-sm max-w-lg">Studi Independen adalah program yang memberikan kesempatan kepada
            mahasiswa untuk mempelajari kompetensi yang spesifik dan praktis langsung dari para pakarnya selama 1 (satu)
            semester melalui aktivitas pembelajaran dan praktik langsung.
          </p>
        </div>
      </div>
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
            <a href="" class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing
              elit.</a>
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