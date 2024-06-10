@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl min-h-screen mx-auto grid grid-cols-12 py-44 px-4 lg:px-12 gap-4">
    <div class="flex col-span-12 mb-2 mt-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="{{ route('student.dashboard') }}"
                    class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-color-primary-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    Beranda
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="{{ route('dosen.program.detail', ['lowongan_id' => $data->programTransaction->lowongan->id, 'lokasi_id' => $data->programTransaction->lokasi->id]) }}"
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Program</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                    <a href="#"
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Log
                        Book</a>
                </div>
            </li>
        </ol>
    </div>
    <div class="col-span-4">
        <div
            class="relative overflow-visible bg-white p-6 rounded-xl w-full flex gap-x-4 border border-slate-200 shadow-sm  transition-all duration-300">
            <div class="w-16 rounded-full">
                <img src="/images/avatar/placeholder.jpg" alt="" class="rounded-full">
            </div>
            <div>
                <p class="font-semibold text-sm">{{ $data->programTransaction->mahasiswa->name }}</p>
                <p class="text-sm">{{ $data->programTransaction->mahasiswa->nim }}</p>
                <div class="flex gap-x-2 items-center text-color-primary-500">
                    <span class=""><i class="fas fa-book text-sm"></i></span>
                    <p class="text-sm font-semibold">{{ $data->programTransaction->lowongan->program->name }}</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-white p-6 rounded-lg shadow broder border-gray-200 mt-2">
            <div class="flex flex-col mt-4">
                <p class="font-semibold text-lg">
                    {{ \Carbon\Carbon::parse($data->start_date)->isoFormat('D MMMM YYYY') }} -
                    {{ \Carbon\Carbon::parse($data->end_date)->isoFormat('D MMMM YYYY') }}</p>

                {{-- <span class="text-sm text-slate-500">Minggu Ke-10</span> --}}
            </div>
            <hr class="mb-4 mt-4">
            @if ($data->status == 'proses')
            <form id="reviewForm" method="POST" action="{{ route('dosen.weekly_review.submit', ['id' => $data->id]) }}">
                @csrf
                <div class="mb-4">
                    <label for="deskripsi" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">
                        Feedback <span class="text-xs font-semibold">(Isi Jika LogBook Ditolak)</span>
                    </label>
                    <textarea id="deskripsi" name="msg" placeholder="Feedback"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"></textarea>
                </div>

                <!-- Hidden input for status -->
                <input type="hidden" id="status" name="status" value="">

                <div class="inline-flex">
                    <!-- Button to set status to 'terima' -->
                    <button type="button" onclick="setStatus('terima')"
                        class="text-white w-full h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Setujui
                    </button>

                    <!-- Button to set status to 'tolak' -->
                    <button type="button" onclick="setStatus('tolak')"
                        class="text-white w-full h-full bg-color-danger-500 hover:bg-color-danger-600 focus:ring-4 focus:ring-color-danger-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                        Tolak
                    </button>
                </div>

            </form>
            @endif

            <script>
                function setStatus(status) {
                        document.getElementById('status').value = status; // Set value based on button clicked
                        document.getElementById('reviewForm').submit(); // Submit the form
                    }
            </script>

        </div>
    </div>
    <div class="lg:col-span-8 col-span-12 w-full flex flex-col gap-y-4">
        <div class="col-span-8 w-full flex flex-col gap-y-2">
            <div class="p-8 bg-white w-full rounded-xl border border-gray-200 shadow mb-4">
                <button class="w-full flex justify-between items-center" onclick="openDetails(this)">
                    <div class="flex gap-x-4 items-center">
                        @php
                        $statusColor = '';
                        $iconClass = '';

                        switch ($data->status) {
                        case 'terima':
                        $statusColor = 'success';
                        $iconClass = 'fas fa-check-circle';
                        break;
                        case 'proses':
                        $statusColor = 'warning';
                        $iconClass = 'fas fa-hourglass-half';
                        break;
                        case 'tolak':
                        $statusColor = 'danger';
                        $iconClass = 'fas fa-times-circle';
                        break;
                        case 'belum':
                        $statusColor = 'primary';
                        $iconClass = 'fas fa-question-circle';
                        break;
                        default:
                        $statusColor = 'secondary';
                        $iconClass = 'fas fa-exclamation-circle';
                        break;
                        }
                        @endphp
                        <span
                            class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-white rounded-full bg-color-{{ $statusColor }}-500">
                            <i class="{{ $iconClass }} text-lg"></i>
                        </span>
                        <div class="flex flex-col justify-start items-start">

                            <p class="font-semibold"> {{ \Carbon\Carbon::parse($data->start_date)->format('d F Y') }} -
                                {{ \Carbon\Carbon::parse($data->end_date)->format('d F Y') }}</p>


                        </div>
                    </div>
                    <div>
                        <i class="fas fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div class="mt-4 flex-col gap-y-4 hidden detailContainer">

                    <br>
                    <div class="overflow-x-auto">
                        <table id="weekly" class="w-full text-sm">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Deskripsi</th>
                                    <th>Rencana</th>
                                    <th>Presentase</th>
                                    <th>Hambatan</th>
                                    <th>Solusi</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->activity as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->desc }}</td>
                                    <td>{{ $a->rencana }}</td>
                                    <td>{{ $a->presentase }}%</td>
                                    <td>{{ $a->hambatan }}</td>
                                    <td>{{ $a->solusi }}</td>
                                    <td>{{ $a->jam_mulai }}</td>
                                    <td>{{ $a->jam_selesai }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-4 mb-4">

                </div>

            </div>
            @foreach ($data->daily as $item)
            <div class="p-8 bg-white w-full rounded-xl border border-gray-200 shadow mb-4">
                <button class="w-full flex justify-between items-center" onclick="openDetails(this)">
                    <div class="flex gap-x-4 items-center">
                        @php
                        $statusColor = '';
                        $iconClass = '';

                        switch ($item->status) {
                        case 'terima':
                        $statusColor = 'success';
                        $iconClass = 'fas fa-check-circle';
                        break;
                        case 'proses':
                        $statusColor = 'warning';
                        $iconClass = 'fas fa-hourglass-half';
                        break;
                        case 'tolak':
                        $statusColor = 'danger';
                        $iconClass = 'fas fa-times-circle';
                        break;
                        case 'belum':
                        $statusColor = 'primary';
                        $iconClass = 'fas fa-question-circle';
                        break;
                        default:
                        $statusColor = 'secondary';
                        $iconClass = 'fas fa-exclamation-circle';
                        break;
                        }
                        @endphp
                        <span
                            class="inline-flex items-center justify-center w-12 h-12 text-sm font-semibold text-white rounded-full bg-color-{{ $statusColor }}-500">
                            <i class="{{ $iconClass }} text-lg"></i>
                        </span>
                        <div class="flex flex-col justify-start items-start">
                            @php
                            $dayName = \Carbon\Carbon::parse($item->date)
                            ->locale('id')
                            ->isoFormat('dddd');
                            @endphp
                            <p class="font-semibold">{{ $dayName }}</p>
                            <span class="text-sm text-slate-500">{{ $item->date }}</span>


                        </div>
                    </div>
                    <div>
                        <i class="fas fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div class="mt-4 flex-col gap-y-4 hidden detailContainer">
                    <label for="">Dokumentasi</label>
                    <form action="" class="flex items-center w-full gap-x-2">
                        <div class="relative w-full ">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <span>
                                    <i class="fas fa-link text-lg text-slate-500"></i>
                                </span>
                            </div>
                            <input type="text" id="input-group-1"
                                class="bg-gray-50 border block border-gray-300 text-gray-900  text-xs rounded-md w-full ps-12 p-4  "
                                placeholder="https://kampusmerdeka.kemdikbud.go.id/program/magang-mandiri/browse/185c2258-bf50-4211-b460-4ed6f1db081c/95ff7b3f-1a14-40f3-b142-0cdc24aa5d9a"
                                disabled value={{ $item->dokumentasi }}>
                        </div>
                        <a href="{{ $item->dokumentasi }}" target="_blank" rel="noopener noreferrer"
                            class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-3.5 me-2">
                            Lihat
                        </a>
                    </form>
                    <br>
                    <div class="overflow-x-auto text-xs">
                        <table id="table_config_{{ $item->id }}" class="w-full text-xs">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Deskripsi</th>
                                    <th>Rencana</th>
                                    <th>Presentase</th>
                                    <th>Hambatan</th>
                                    <th>Solusi</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($item->activity as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->desc }}</td>
                                    <td>{{ $data->rencana }}</td>
                                    <td>{{ $data->presentase }}%</td>
                                    <td>{{ $data->hambatan }}</td>
                                    <td>{{ $data->solusi }}</td>
                                    <td>{{ $data->jam_mulai }}</td>
                                    <td>{{ $data->jam_selesai }}</td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="mt-4 mb-4">
                    @if ($item->status == 'proses')
                    <x-button_md type="button"
                        class=""
                        color="primary"
                        onclick="window.location='{{ route('dpl.weekly.review', ['id' => $item->id]) }}'">
                        Periksa
                    </x-button_md>
                    @endif

                </div>

            </div>
            @endforeach

        </div>
</section>
<script>
    // Menggunakan kelas 'detailContainer' sebagai selektor umum untuk semua elemen yang ingin Anda kontrol
        const detailContainers = document.querySelectorAll('.detailContainer');

        // Fungsi openDetails menerima parameter elemen yang diklik
        const openDetails = (element) => {
            // Temukan kontainer detail yang sesuai dengan elemen yang diklik
            const detailContainer = element.nextElementSibling;

            // Periksa apakah detailContainer memiliki kelas 'hidden'
            if (detailContainer.classList.contains('hidden')) {
                // Jika memiliki kelas 'hidden', hapus kelas tersebut
                detailContainer.classList.remove('hidden');
                detailContainer.classList.add('flex');
            } else {
                // Jika tidak memiliki kelas 'hidden', tambahkan kelas tersebut
                detailContainer.classList.remove('flex');
                detailContainer.classList.add('hidden');
            }
        };
</script>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
            $('#weekly').DataTable();
        });
        $(document).ready(function() {
    $('table[id^="table_config_"]').each(function() {
        $(this).DataTable();
    });
});
</script>
@endsection