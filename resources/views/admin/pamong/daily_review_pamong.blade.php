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
                    <a href="{{ route('guru.program.detail', ['lowongan_id' => $data->programTransaction->lowongan->id, 'lokasi_id' => $data->programTransaction->lokasi->id]) }}"
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
                    <a href="{{ route('guru.daily.log', ['id' => $data->weekly_log_id]) }}"
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Log
                        Book</a>
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
                        class="ms-1 text-sm font-medium text-gray-700 hover:text-color-primary-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Form</a>
                </div>
            </li>
        </ol>
    </div>
    <div class="col-span-4">

        <div
            class="relative overflow-visible bg-white p-6 rounded-xl w-full flex gap-x-4 border border-slate-200 shadow-sm  transition-all duration-300">
            <div class="w-16 rounded-full">
                <img src="/images/avatar/avatar.jpg" alt="" class="rounded-full">
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
        <div class="w-full bg-white p-6 rounded-lg shadow broder border-gray-200 mt-4">
            <div class="flex flex-col mt-4">
                <p class="font-semibold text-lg">
                    {{ \Carbon\Carbon::parse($data->date)->locale('id')->isoFormat('dddd, D MMM YYYY') }}</p>
                {{-- <span class="text-sm text-slate-500">Minggu Ke-10</span> --}}
            </div>
            <hr class="mb-4 mt-4">
            <form id="reviewForm" method="POST"
                action="{{ route('guru.daily.submit', ['id' => $data->id, 'status' => 'tolak']) }}">
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
            <div class="p-8 bg-white w-full rounded-xl broder border-gray-200 shadow">
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
                        @php
                        $dayName = \Carbon\Carbon::parse($data->date)
                        ->locale('id')
                        ->isoFormat('dddd');
                        @endphp
                        <p class="font-semibold">{{ $dayName }}</p>
                        <span class="text-sm text-slate-500">{{ $data->date }}</span>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-y-4">
                    <table id="table_config_{{ $item->id }}" class="w-full text-sm">
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
                            @foreach ($data->activity as $data)
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
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
    $('table[id^="table_config_"]').each(function() {
        $(this).DataTable();
    });
});
</script>
@endsection