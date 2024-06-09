<header class="fixed z-20 bg-white w-full border-b-2 border-color-primary-500 font-Poppins">
  <nav class="bg-white w-full max-w-screen-xl mx-auto flex justify-between items-center p-4 px-4">
    <div class="col-span-12 lg:col-span-4 flex items-center gap-x-2">
      <img src="/images/avatar/kemendikbud.png" alt="" class="w-10 lg:w-14">
      <img src="/images/avatar/ung.png" alt="" class="w-10 lg:w-12">
      <img src="/images/avatar/km_colored.png" alt="" class="w-10 lg:w-14">
    </div>
    <ul class="items-center gap-x-4 hidden lg:flex">
      <li>
        <a href="{{ route('home') }}"
          class="p-2 {{ Route::currentRouteNamed('home') ? 'font-semibold text-color-primary-500' : '' }}">Beranda</a>
      </li>
      <li
        class="p-2 relative hover:cursor-pointer {{ Route::currentRouteNamed('infografis') ? 'font-semibold text-color-primary-500' : '' }}"
        onclick="openDropDown(this)">
        <p class="">Infografis</p>
        <div
          class="absolute hidden top-full p-4 bg-white text-sm rounded-md shadow-lg border border-slate-200 flex-col gap-y-2 w-max dropdown_menu">
          <ul>
            <li><a href="{{ route('infografis') }}" class="p-2">Peserta MBKM</a></li>
          </ul>
        </div>
      </li>
      <li
        class="p-2 relative hover:cursor-pointer {{ Route::currentRouteNamed('berita') ? 'font-semibold text-color-primary-500' : '' }}"
        onclick="openDropDown(this)">
        <p>Berita</p>
        <div
          class="absolute hidden top-full p-4 bg-white text-sm rounded-md shadow-lg border border-slate-200 flex-col gap-y-2 w-max dropdown_menu">
          <ul>
            <li><a href="{{ route('berita') }}" class="p-2">Semua Berita</a></li>
          </ul>
        </div>
      </li>
      <li class="{{ Route::currentRouteNamed('home') ? 'font-semibold text-color-primary-500' : '' }}">
        <a href="{{ route('login') }}"
          class="py-3 px-5 inline-flex font-semibold items-center gap-x-2 bg-color-primary-500 hover:bg-color-primary-600 text-white rounded-md text-sm">
          <span><i class="fas fa-user"></i></span>
          Login
        </a>
      </li>
    </ul>
    <button class="px-4 py-2.5 lg:hidden block text-slate-500 rounded-lg" onclick="handleMenuClick()">
      <i class="fas fa-bars"></i>
    </button>
    <div
      class="absolute translate-x-[100%] transition-transform z-[30] w-screen h-screen top-0 right-0 left-0 bottom-0 bg-white p-4 flex flex-col gap-y-2 text-sm overflow-y-auto"
      id="adminNav">
      <div class="p-2 flex items-center justify-between">
        <img src="/images/avatar/km_colored.png" alt="" class="w-16">
        <button class="px-3 py-1.5 rounded-lg hover:bg-slate-100 text-slate-500" onclick="handleMenuClick()">
          <i class="fas fa-times text-lg"></i>
        </button>
      </div>
      <li class="p-4 flex items-center bg-color-primary-500 text-white rounded-lg">
        <a href="{{ route('home') }}" class="flex items-center gap-x-2">
          <i class="fas fa-home"></i>
          Beranda
        </a>
      </li>
      <li class="p-4 flex items-center bg-color-primary-500 text-white rounded-lg hover:cursor-pointer"
        onclick="openDropDown(this)">
        <div class="flex flex-col items-center w-full">
          <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-x-2">
              <i class="fas fa-box"></i>
              Infografis
            </div>
            <span><i class="fas fa-chevron-down"></i></span>
          </div>
          <div class="flex-col gap-y-2 p-4 bg-white text-color-primary-500 rounded-lg hidden w-full mt-4 dropdown_menu">
            <a href="{{ route('infografis') }}" class="flex items-center gap-x-2">
              <i class="fas fa-file"></i>
              Peserta MBKM
            </a>
          </div>
        </div>
      </li>
      <li class="p-4 flex items-center bg-color-primary-500 text-white rounded-lg hover:cursor-pointerg"
        onclick="openDropDown(this)">
        <div class="flex flex-col items-center w-full">
          <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-x-2">
              <i class="fas fa-box"></i>
              Berita
            </div>
            <span><i class="fas fa-chevron-down"></i></span>
          </div>
          <div class="flex-col gap-y-2 p-4 bg-white text-color-primary-500 rounded-lg hidden w-full mt-4 dropdown_menu">
            <a href="{{ route('berita') }}" class="flex items-center gap-x-2">
              <i class="fas fa-file"></i>
              Semua Berita
            </a>
          </div>
        </div>
      </li>
      <li class="flex items-center text-white rounded-lg">
        <x-button_md color="primary" class="w-fit inline-flex items-center gap-x-2" onclick="window.location.href='{{ route('login') }}'">
          <span><i class="fas fa-user"></i></span>
          Masuk
        </x-button_md>
      </li>
    </div>
  </nav>
</header>
<script>
  const openDropDown = (element) => {
    const dropdownMenu = element.querySelector('.dropdown_menu');
    const isMobileNav = element.closest('#adminNav') !== null;

    if (dropdownMenu.classList.contains('hidden')) {
        dropdownMenu.classList.remove('hidden');
        dropdownMenu.classList.add('flex');
        
        if (isMobileNav) {
            // Change background color to primary for mobile nav
            element.classList.add('bg-color-primary-500');
            element.classList.add('text-white');
        }
    } else {
        dropdownMenu.classList.remove('flex');
        dropdownMenu.classList.add('hidden');
        
        if (isMobileNav) {
            // Revert background color to original for mobile nav
            element.classList.remove('bg-color-primary-500');
            element.classList.remove('text-white');
        }
    }
};

function handleMenuClick() {
    const navMenu = document.getElementById('adminNav');

    // Toggle the side menu
    if (navMenu.classList.contains('translate-x-[100%]')) {
        navMenu.classList.remove('translate-x-[100%]');
        navMenu.classList.add('translate-x-0');
    } else {
        navMenu.classList.remove('translate-x-0');
        navMenu.classList.add('translate-x-[100%]');
    }

    // Close all dropdowns when side menu is closed
    const allDropdowns = document.querySelectorAll('.dropdown_menu');
    allDropdowns.forEach(function (dropdown) {
        dropdown.classList.remove('flex');
        dropdown.classList.add('hidden');
        // Reset background color
        const parentMenu = dropdown.closest('.bg-color-primary-500');
        if (parentMenu) {
            parentMenu.classList.remove('bg-color-primary-500');
            parentMenu.classList.remove('text-white');
        }
    });
}

// Close all dropdowns when clicking outside
document.addEventListener('click', function (event) {
    const isOutsideDropdown = !event.target.closest('.relative') && !event.target.closest('#adminNav');

    if (isOutsideDropdown) {
        const allDropdowns = document.querySelectorAll('.dropdown_menu');
        allDropdowns.forEach(function (dropdown) {
            dropdown.classList.remove('flex');
            dropdown.classList.add('hidden');
            // Reset background color
            const parentMenu = dropdown.closest('.bg-color-primary-500');
            if (parentMenu) {
                parentMenu.classList.remove('bg-color-primary-500');
                parentMenu.classList.remove('text-white');
            }
        });
    }
});

</script>