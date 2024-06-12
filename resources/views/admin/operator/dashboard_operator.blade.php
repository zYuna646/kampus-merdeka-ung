@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 p-32 px-4 lg:px-12 gap-4">
    <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-reverse rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 1 1 1-1h2a1 1 0 1 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Beranda
                </a>
            </li>
        </ol>
    </div>
    <div class="col-span-12 w-full">
        <div class="p-6 bg-white border border-slate-200 shadow-sm rounded-xl flex flex-col gap-y-4">
            <h1 class="text-lg font-semibold">Cari Lowongan</h1>
            <div>
                <form id="filter-form" class="w-full grid grid-cols-7 gap-4">
                    <div class="relative mb-2 col-span-12 lg:col-span-3">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <span>
                                <i class="fas fa-book text-lg text-slate-500"></i>
                            </span>
                        </div>
                        <select id="input-group-1"
                            class="bg-gray-50 border block border-gray-300 text-gray-900 xl:text-sm text-xs rounded-lg w-full ps-12 p-4">
                            <option value="">Pilih Program</option>
                            @foreach ($data['program'] as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="relative mb-2 col-span-12 lg:col-span-3">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <span>
                                <i class="fas fa-calendar text-lg text-slate-500"></i>
                            </span>
                        </div>
                        <select id="input-group-2"
                            class="bg-gray-50 border block border-gray-300 text-gray-900 xl:text-sm text-xs rounded-lg w-full ps-10 p-4">
                            <option value="">Pilih Tahun Akademik</option>
                        </select>
                    </div>
                    <div class="col-span-3 lg:col-span-1">
                        <button type="button" id="filter-button"
                            class="text-white w-full h-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-base px-5 py-3.5 me-2">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="lg:col-span-4 col-span-12 w-full ">
        <p class="text-sm italic my-4">Total Lowongan : <span id="total-lowongan">{{ $data['lowongan']->count()
                }}</span></p>
        <div id="lowongan-list" class="w-full max-h-[42rem] overflow-y-auto flex flex-col gap-y-4">
            @foreach ($data['lowongan'] as $item)
            <div onclick="showProgramDetail({{$item->id}})" data-program-id="{{ $item->program->id }}"
                data-tahun-akademik="{{ $item->tahun_akademik }}"
                class="lowongan-item w-full bg-white border border-gray-200 hover:border-color-primary-500 hover:bg-slate-100 transition-colors duration-300 rounded-lg shadow">
                <a class="w-full">
                    <img class="rounded-t-lg w-full brightness-50" src="/images/hero-image/image.png" alt="" />
                </a>
                <div class="p-6">
                    <div class="">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-x-2 items-center text-color-primary-500">
                                <span class=""><i class="fas fa-book text-sm"></i></span>
                                <p class="text-sm font-semibold">{{ $item->program->name }}</p>
                            </div>
                            <span>
                                <span class=""><i class="fas fa-chevron-right text-xs"></i></span>
                            </span>
                        </div>
                        <p class="text-base mt-1"></p>
                        <p class="text-sm mt-1 text-slate-500">{{ $item->tahun_akademik . ' (' . $item->semester . ')'
                            }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
        <div id="program_detail"></div>
    </div>
</section>
<script>
    function showProgramDetail(lowonganId) {
          // Menggunakan AJAX untuk mengambil detail peserta dari server
          $.ajax({
              type: 'GET',
              url: '/dashboard/operator/get-lowongan/' + lowonganId,
              success: function(response) {
                  // Memperbarui konten di sebelah kanan dengan detail peserta yang baru
                  $('#program_detail').html(response);
              },
              error: function(xhr, status, error) {
                  console.error(error);
              }
          });
      }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const selectElement2 = document.getElementById('input-group-2');
            const startYear = 2020;
            const endYear = 2050;

            for (let year = startYear; year <= endYear; year++) {
                const academicYear = `${year}-${year + 1}`;
                const option = document.createElement('option');
                option.value = academicYear;
                option.textContent = academicYear;
                selectElement2.appendChild(option);
            }

            document.getElementById('filter-button').addEventListener('click', function() {
                const programId = document.getElementById('input-group-1').value;
                const tahunAkademik = document.getElementById('input-group-2').value;
                filterLowongan(programId, tahunAkademik);
            });
        });

        function filterLowongan(programId, tahunAkademik) {
            const lowonganItems = document.querySelectorAll('.lowongan-item');
            let totalLowongan = 0;
            console.log(tahunAkademik);

            lowonganItems.forEach(item => {
                const itemProgramId = item.getAttribute('data-program-id');
                console.log(itemProgramId);
                const itemTahunAkademik = item.getAttribute('data-tahun-akademik');
                console.log(itemTahunAkademik);

                if ((programId === '' || itemProgramId === programId) && (tahunAkademik === '' || itemTahunAkademik === tahunAkademik)) {
                    item.style.display = 'block';
                    totalLowongan++;
                } else {
                    item.style.display = 'none';
                }
            });

            document.getElementById('total-lowongan').textContent = totalLowongan;
        }
</script>
@endsection