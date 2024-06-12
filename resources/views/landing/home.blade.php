@extends('layout.landing')

@section('main')
<section class="h-screen w-full relative flex items-center justify-center">
    <div class="h-full w-full brightness-50 bg-cover">
        <img src="/images/hero-image/rektorat2.jpg" alt="" class="w-full h-full object-cover brightness-50">
    </div>
    <div class="flex flex-col gap-y-2 absolute z-10 text-white w-full max-w-screen-xl px-8">
        <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold">Kampus <span
                class="text-color-primary-500">Merdeka</span>
        </h1>
        <p class="text-lg">Universitas Negeri Gorontalo</p>
        <p class="text-sm max-w-sm">
            Pantau aktivitas mahasiswa MBKM di UNG dengan mudah! Dapatkan solusi terpadu untuk transparansi dan
            kesuksesan program MBKM dalam satu platform resmi UNG. Pastikan kemajuan dan evaluasi kegiatan dengan
            aplikasi monitoring inovatif kami.
        </p>
    </div>
</section>
<section class=" min-h-screen bg-neutral-950 flex items-center justify-center flex-wrap">
    <div class="max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
        <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
            <img src="/images/avatar/km_colored.png" alt="" class="rounded-xl w-4/6">
        </div>
        <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4 text-white">
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
            <x-button_md color="primary" class="w-fit"
                onclick="window.location.href='https://kampusmerdeka.kemdikbud.go.id/'">
                Cari Tahu
            </x-button_md>
        </div>
    </div>
</section>
<section class="min-h-screen w-full max-w-screen-xl mx-auto  bg-white flex items-center justify-center flex-wrap">
    <div class="swiper h-full">
        <div class="swiper-wrapper h-full">
            <div
                class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
                <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                    <img src="/images/avatar/iisma_hero.png" alt="" class="rounded-xl w-4/6">
                </div>
                <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
                    <h2 class="text-xl lg:text-4xl font-bold">IISMA<span class="text-color-primary-500"></span></h2>
                    <p class="text-xs lg:text-xl font-semibold">Perluas wawasan dan koneksi melalui Pertukaran Mahasiswa
                        secara
                        Internasional</p>
                    <p class="text-xs lg:text-sm max-w-lg">Indonesian International Student Mobility Awards (IISMA) is a
                        scholarship scheme by the Ministry of Education, Culture, Research, and Technology of the
                        Republic of
                        Indonesia to fund Indonesian students for a one semester-mobility program at top universities
                        and reputable
                        industries overseas.
                    </p>
                    <x-button_md class="w-fit" color="primary"
                        onclick="window.location.href='https://kampusmerdeka.kemdikbud.go.id/program'">
                        Lihat Program
                    </x-button_md>
                </div>
            </div>
            <div
                class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
                <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                    <img src="/images/avatar/kampus_mengajar_hero.png" alt="" class="rounded-xl w-4/6">
                </div>
                <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
                    <h2 class="text-xl lg:text-4xl font-bold">Kampus <span
                            class="text-color-primary-500">Mengajar</span></h2>
                    <p class="text-xs lg:text-xl font-semibold">Bantu tingkatkan kualitas
                        pengajaran pendidikan
                        dasar melalui Kampus Mengajar</p>
                    <p class="text-xs lg:text-sm max-w-lg">
                        Kampus Mengajar merupakan kanal pembelajaran yang memberikan kesempatan kepada mahasiswa untuk
                        belajar di
                        luar kampus selama satu semester guna melatih kemampuan menyelesaikan permasalahan yang kompleks
                        dengan
                        menjadi mitra guru untuk berinovasi dalam pembelajaran, pengembangan strategi, dan model
                        pembelajaran yang
                        kreatif, inovatif, dan menyenangkan.
                    </p>
                    <x-button_md class="w-fit" color="primary"
                        onclick="window.location.href='https://kampusmerdeka.kemdikbud.go.id/program'">
                        Lihat Program
                    </x-button_md>
                </div>
            </div>
            <div
                class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
                <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                    <img src="/images/avatar/msib_hero.png" alt="" class="rounded-xl w-4/6">
                </div>
                <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
                    <h2 class="text-xl lg:text-4xl font-bold">Magang <span class="text-color-primary-500">MSIB</span>
                    </h2>
                    <p class="text-xs lg:text-xl font-semibold">Rasakan pengalaman
                        dunia kerja dengan terjun
                        langsung melalui Magang MSIB</p>
                    <p class="text-xs lg:text-sm max-w-lg">Magang MSIB adalah program magang yang diawasi langsung oleh
                        Kemendikbudristek selama 1 (satu) semester untuk mendapatkan pengalaman kerja dan pengetahuan
                        tentang
                        praktik terbaik dari industri yang kamu minati!
                    </p>
                    <x-button_md class="w-fit" color="primary"
                        onclick="window.location.href='https://kampusmerdeka.kemdikbud.go.id/program'">
                        Lihat Program
                    </x-button_md>
                </div>
            </div>
            <div
                class="swiper-slide h-full max-w-screen-xl mx-auto grid grid-cols-6 gap-12 px-6 items-center py-12 lg:py-0">
                <div class="col-span-6 lg:col-span-3 flex items-center justify-center">
                    <img src="/images/avatar/msib_hero.png" alt="" class="rounded-xl w-4/6">
                </div>
                <div class="col-span-6 lg:col-span-3 flex flex-col gap-y-4">
                    <h2 class="text-xl lg:text-4xl font-bold">Studi <span
                            class="text-color-primary-500">Independen</span></h2>
                    <p class="text-xs lg:text-xl font-semibold">Riset kolaboratif bersama perusahaan ternama
                        melalui Studi Independen</p>
                    <p class="text-xs lg:text-sm max-w-lg">Studi Independen adalah program yang memberikan kesempatan
                        kepada
                        mahasiswa untuk mempelajari kompetensi yang spesifik dan praktis langsung dari para pakarnya
                        selama 1 (satu)
                        semester melalui aktivitas pembelajaran dan praktik langsung.
                    </p>
                    <x-button_md class="w-fit" color="primary"
                        onclick="window.location.href='https://kampusmerdeka.kemdikbud.go.id/program'">
                        Lihat Program
                    </x-button_md>
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
        @foreach ($latestNews as $news)
        <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
            <a href="{{ route('detail_news', $news->id) }}" class="col-span-12 lg:col-span-6">
                <img src="{{ Storage::url($news->cover) }}" alt="" class="rounded-lg w-full object-cover lg:h-56 h-36">
            </a>
            <div class="col-span-12 lg:col-span-6 flex flex-col justify-between py-2 gap-y-4">
                <div class="flex flex-col gap-y-4">
                    <a href="{{ route('detail_news', $news->id) }}" class="font-semibold lg:text-lg news-title">{{
                        $news->title }}</a>
                    <p class="text-xs lg:text-sm truncate-text" data-text="{{ $news->content }}"></p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">{{ Carbon\Carbon::parse($news->created_at)->format('Y-m-d') }}</p>
                    <a href="{{ route('news_by_category', $news->category->name) }}"
                        class="uppercase font-semibold text-sm text-color-primary-500">{{ $news->category->name }}</a>
                </div>
            </div>
        </div>
        @endforeach

        <div class="px-4">
            <x-button_md type="submit" class="w-fit" onclick="window.location.href='{{ route('berita') }}'">
                Lihat Semua Berita
            </x-button_md>
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
        {{-- <div>
            <h2 class="font-semibold text-lg px-4">
                Berita Terpopuler
            </h2>
            <div class="grid grid-flow-row divide-y-[1px]">
                <div class="p-4 bg-white  grid grid-cols-12 gap-4">
                    <div class="col-span-6 rounded-lg">
                        <img src="/images/hero-image/image.png" alt="" class="rounded-md w-full h-24 object-cover">
                    </div>
                    <div class="col-span-6 flex flex-col gap-y-2">
                        <a href="" class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur,
                            adipisicing
                            elit.</a>
                        <p class="text-sm text-slate-500">14 Juni 2023</p>
                    </div>
                </div>
            </div>
        </div> --}}
        <div>
            <h2 class="font-semibold text-lg px-4">
                Download
            </h2>
            <div class="p-4 grid grid-flow-row divide-y-[1px]">
                <div class="p-3 bg-white grid grid-cols-12 gap-4">
                    <p class="text-sm col-span-10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates
                        aliquam,
                    </p>
                    <button class="col-span-2 hover:text-slate-500 transition-colors duration-300">
                        <span><i class="fas fa-download"></i></span>
                    </button>
                </div>
                <div class="p-3 bg-white grid grid-cols-12 gap-4">
                    <p class="text-sm col-span-10">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptates
                        aliquam,
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const truncateTextElements = document.querySelectorAll('.truncate-text');
        const truncateTextLength = 200; // Set the length for truncating
  
        truncateTextElements.forEach(function(element) {
            const fullText = element.getAttribute('data-text');
            const plainText = fullText.replace(/<\/?[^>]+(>|$)/g, ""); // Remove HTML tags
            if (plainText.length > truncateTextLength) {
                const truncatedText = plainText.substring(0, truncateTextLength) + '...';
                element.textContent = truncatedText;
            } else {
                element.textContent = plainText;
            }
        });
    });
</script>
@endsection