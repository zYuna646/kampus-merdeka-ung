@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Peserta</h2>
        <form action="{{ route('admin.peserta.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="mahasiswa" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa"
                    class="js-example-basic-single block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['mahasiswa'] as $item)
                    <option value="{{ $item->id }}">{{ $item->nim . ' - ' . $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="lowongan_id" id="program"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    <option value="">Pilih Program</option>
                    @foreach ($data['program'] as $item)
                    <option value="{{ $item->id }}" data-program-id="{{ $item->program_id }}">{{$item->program->name . '
                        (' . $item->tahun_akademik . ')' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4" id="lokasi-container" style="display: none;">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select name="lokasi_id" id="lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    <!-- Lokasi akan diisi oleh JavaScript berdasarkan program yang dipilih -->
                </select>
            </div>

            <x-button_md color="primary" class="w-full" type="submit">
                Kirim
            </x-button_md>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const programSelect = document.getElementById('program');
        const lokasiContainer = document.getElementById('lokasi-container');
        const lokasiSelect = document.getElementById('lokasi');

        const lokasiData = @json($data['lokasi']);

        programSelect.addEventListener('change', function () {
            const selectedProgramId = this.options[this.selectedIndex].getAttribute('data-program-id');

            // Tampilkan elemen lokasi hanya jika program dipilih
            if (selectedProgramId) {
                lokasiContainer.style.display = 'block';
                populateLokasiOptions(selectedProgramId);
            } else {
                lokasiContainer.style.display = 'none';
                lokasiSelect.innerHTML = '';
            }
        });

        function populateLokasiOptions(programId) {
            lokasiSelect.innerHTML = '';

            // Filter lokasi berdasarkan program yang dipilih
            const filteredLokasi = lokasiData.filter(lokasi => lokasi.program_id == programId);

            filteredLokasi.forEach(lokasi => {
                const option = document.createElement('option');
                option.value = lokasi.id;
                option.textContent = lokasi.name;
                lokasiSelect.appendChild(option);
            });
        }
    });
</script>
<script>
    $(document).ready(function () {
        function initializeSelect2() {
            $('.js-example-basic-single').select2();
        }
        initializeSelect2();
    })

</script>
@endsection