<nav class="bg-color-primary-500 text-white fixed z-10 w-full shadow-sm font-Poppins">
    <div class="w-full p-4 max-w-screen-xl mx-auto flex justify-between items-center">
        <div>
            <img src="/images/avatar/km_white.png" alt="" class="w-20">
        </div>
        <div class="relative cursor-pointer" onclick="openDropDown(this)">
            @auth
                @if (Auth::user()->profile != '')
                    <img src="{{ Auth::user()->profile }}" alt="" class="w-12 rounded-full border-2 border-white">
                @else
                    <img src="/images/avatar/avatar.jpg" alt="" class="w-12 rounded-full border-2 border-white">
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
            @endauth

            <div
                class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                <p class="w-full text-color-primary-600">@auth
                        {{ Auth::user()->username }}
                    @endauth
                </p>

                <div class="inline-flex items-center gap-x-2 text-slate-500 w-full">
                    <i class="fas fa-user-circle"></i> <!-- Mengubah ikon menjadi ikon profil -->
                    <p class="w-full">Profile</p>
                </div>
                <div class="inline-flex items-center gap-x-2 text-red-400">
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> <!-- Mengubah ikon menjadi ikon keluar -->
                        Log Out
                    </a>
                </div>
            </div>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>

    @auth
        @if (Auth::user()->role->slug === 'admin')
            <div class="w-full bg-white">
                <div class="max-w-screen-xl mx-auto text-black list-none flex items-center p-4 gap-x-8 text-sm">
                    <li class="p-2">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Beranda
                            </a>
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-box"></i>
                            Master
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <div class="inline-flex items-center gap-x-2 text-slate-500 w-full">
                                <a href="{{ route('admin.campus_merdeka_program') }}">

                                    <i class="fas fa-file"></i>
                                    Program Kampus Merdeka
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.faculties') }}">

                                    <i class="fas fa-file"></i>
                                    Fakultas
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.departement') }}">

                                    <i class="fas fa-file"></i>
                                    Jurusan
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.study_program') }}">

                                    <i class="fas fa-file"></i>
                                    Program Studi
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-columns"></i>
                            Program KM
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <!-- Isi dropdown Program KM di sini -->
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-columns"></i>
                            Website
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <!-- Isi dropdown Website di sini -->
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-columns"></i>
                            MBKM
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <!-- Isi dropdown MBKM di sini -->
                            <div class="inline-flex items-center gap-x-2 text-slate-500 w-full">
                                <a href="{{ route('admin.dosen') }}">

                                    <i class="fas fa-file"></i>
                                    Dosen
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.student') }}">

                                    <i class="fas fa-file"></i>
                                    Mahasiswa
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.guru') }}">

                                    <i class="fas fa-file"></i>
                                    Guru
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.location') }}">

                                    <i class="fas fa-file"></i>
                                    Lokasi
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.dpl') }}">

                                    <i class="fas fa-file"></i>
                                    DPL
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.lowongan') }}">

                                    <i class="fas fa-file"></i>
                                    Lowongan
                                </a>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <a href="{{ route('admin.peserta') }}">

                                    <i class="fas fa-file"></i>
                                    Peserta
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-columns"></i>
                            Laporan
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <!-- Isi dropdown Laporan di sini -->
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-columns"></i>
                            Infografis
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <div class="inline-flex items-center gap-x-2 text-slate-500 w-full">
                                <i class="fas fa-file"></i>
                                <p class="w-full">Program MBKM</p>
                            </div>
                            <div class="inline-flex items-center gap-x-2  text-slate-500">
                                <i class="fas fa-file"></i>
                                Perserta MBKM
                            </div>
                        </div>
                    </li>
                </div>
            </div>
        @endif
    @endauth


    @auth
        @if (Auth::user()->role->slug === 'mahasiswa')
            <div class="w-full bg-white">
                <div class="max-w-screen-xl mx-auto text-black list-none flex items-center p-4 gap-x-8 text-sm">
                    <li class="p-2">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <a href="{{ route('student.dashboard') }}">
                                <i class="fas fa-home"></i>
                                Beranda
                            </a>
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-box"></i>
                            Aktifitas
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div
                            class="absolute hidden top-full p-4 bg-white text-xs rounded-xl shadow-md flex-col gap-y-2 w-max dropdown_menu">
                            <a href="{{ route('student.weekly_logbook') }}"
                                class="inline-flex items-center gap-x-2 text-slate-500 w-full">
                                <i class="fas fa-file"></i>
                                Log Book
                            </a>
                        </div>
                    </li>
                    <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
                        <div class="inline-flex items-center gap-x-2  text-slate-500">
                            <i class="fas fa-file"></i>
                            laporan
                        </div>
                    </li>
                </div>
            </div>
        @endif
    @endauth

</nav>

<script>
    const openDropDown = (element) => {
        // Temukan kontainer dropdown yang merupakan anak langsung dari elemen yang diklik
        const dropdownMenu = element.querySelector('.dropdown_menu');

        // Periksa apakah dropdownMenu memiliki kelas 'hidden'
        if (dropdownMenu.classList.contains('hidden')) {
            // Jika memiliki kelas 'hidden', hapus kelas tersebut
            dropdownMenu.classList.remove('hidden');
            dropdownMenu.classList.add('flex');
        } else {
            // Jika tidak memiliki kelas 'hidden', tambahkan kelas tersebut
            dropdownMenu.classList.remove('flex');
            dropdownMenu.classList.add('hidden');
        }
    };
</script>
