<header class="fixed z-20 bg-white w-full border-b-2 border-color-primary-500 font-Poppins">
  <nav class="bg-white w-full max-w-screen-xl mx-auto flex justify-between items-center p-4 px-4">
    <div class="col-span-12 lg:col-span-4 flex items-center gap-x-2">
      <img src="/images/avatar/kemendikbud.png" alt="" class="w-10 lg:w-14 ">
      <img src="/images/avatar/ung.png" alt="" class="w-10 lg:w-12">
      <img src="/images/avatar/km_colored.png" alt="" class="w-10 lg:w-14">
    </div>
    <ul class=" items-center gap-x-4 hidden lg:flex">
      <li>
        <a href=""
          class="p-2 {{ Route::currentRouteNamed('home') ? 'font-semibold text-color-primary-500' : '' }}">Beranda</a>
      </li>
      <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
        <p>Infografis</p>
        <div
          class="absolute hidden top-full p-4 bg-white text-sm rounded-md shadow-lg border border-slate-200 flex-col gap-y-2 w-max dropdown_menu">
          <ul>
            <li><a href="" class="p-2">Peserta MBKM</a></li>
          </ul>
        </div>
      </li>
      <li class="p-2 relative cursor-pointer" onclick="openDropDown(this)">
        <p>Berita</p>
        <div
          class="absolute hidden top-full p-4 bg-white text-sm rounded-md shadow-lg border border-slate-200 flex-col gap-y-2 w-max dropdown_menu">
          <ul>
            <li><a href="" class="p-2">Semua Berita</a></li>
          </ul>
        </div>
      </li>
      <li class="">
        <a href=""
          class="py-3 px-5 inline-flex items-center gap-x-2 bg-color-primary-500 hover:bg-color-primary-600 text-white rounded-md text-sm">
          <span><i class="fas fa-user"></i></span>
          Login
        </a>
      </li>
    </ul>
    <button class=" px-4 py-2.5 lg:hidden block text-slate-500 rounded-lg" onclick="handleMenuClick()">
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
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-x-2 ">
          <i class="fas fa-home"></i>
          Beranda
        </a>
      </li>
      <li class="p-4 flex items-center bg-color-primary-500 text-white rounded-lg ">
        <div href=" " class="flex flex-col items-center w-full" onclick="openDropDown(this)">
          <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-x-2">
              <i class="fas fa-box"></i>
              Infografis
            </div>
            <span><i class="fas fa-chevron-down"></i></span>
          </div>
          <div
            class=" flex-col gap-y-2 p-4 bg-white text-color-primary-500 rounded-lg hidden w-full mt-4 dropdown_menu">
            <a href="" class="flex items-center gap-x-2">
              <i class="fas fa-file"></i>
              Peserta MBKM
            </a>
          </div>
        </div>
      </li>
      <li class="p-4 flex items-center bg-color-primary-500 text-white rounded-lg ">
        <div href=" " class="flex flex-col items-center w-full" onclick="openDropDown(this)">
          <div class="flex items-center justify-between w-full">
            <div class="flex items-center gap-x-2">
              <i class="fas fa-box"></i>
              Berita
            </div>
            <span><i class="fas fa-chevron-down"></i></span>
          </div>
          <div
            class=" flex-col gap-y-2 p-4 bg-white text-color-primary-500 rounded-lg hidden w-full mt-4 dropdown_menu">
            <a href="{{ route('admin.dosen') }}" class="flex items-center gap-x-2">
              <i class="fas fa-file"></i>
              Semua Berita
            </a>
          </div>
        </div>
      </li>
    </div>
  </nav>
</header>
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

    function handleMenuClick () {
        const naruto = document.getElementById('adminNav')

        if (naruto.classList.contains('translate-x-[100%]')){
            naruto.classList.remove('translate-x-[100%]');
            naruto.classList.add('translate-x-0');
        } else {
            naruto.classList.remove('translate-x-0');
            naruto.classList.add('translate-x-[100%]');
        }

        if (!isDropdownClicked) {
        const allDropdowns = document.querySelectorAll('.dropdown_menu');
        allDropdowns.forEach(function(dropdown) {
            dropdown.classList.remove('flex');
            dropdown.classList.add('hidden');
        });
    }
    }
    
    document.addEventListener('click', function(event) {
        const isOutsideDropdown = !event.target.closest('.relative');

        if (isOutsideDropdown) {
            const allDropdowns = document.querySelectorAll('.dropdown_menu');
            allDropdowns.forEach(function(dropdown) {
                dropdown.classList.remove('flex');
                dropdown.classList.add('hidden');
            });
        }
    });
</script>