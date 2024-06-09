@extends('layout.admin')

@section('main')
<style>
</style>
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-8 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Pamong</h2>
        <form action="{{ route('admin.pamong.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="dosen" class="block text-sm font-medium text-gray-700 mb-2">Pamong</label>
                <select name="pamong_id" id="dosen"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    <option value="" selected disabled>Pilih Pamong</option>
                    @foreach ($data['pamong'] as $item)
                        <option value="{{ $item->id }}">{{ $item->nik . ' - ' . $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="program" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="lowongan_id" id="program"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    <option value="" selected disabled>Pilih Program</option>
                    @foreach ($data['program'] as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->program->name . ' (' . $item->tahun_akademik . ') - ' . $item->semester }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div id="repeater_section" class="mb-4 flex flex-col gap-y-4 hidden">
                <div class="flex items-end justify-between">
                    <p class="block text-sm font-medium text-gray-700">Tambah Mahasiswa</p>

                    <x-button_sm color="primary" id="add_repeater">
                        <span><i class="fas fa-plus"></i></span>
                    </x-button_sm>
                </div>
                <div id="repeater_wrapper" class="flex flex-col gap-y-4">
                    <div class="p-6 bg-slate-100 rounded-md repeater_item">
                        <label for="mahasiswa_1" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa
                            1</label>
                        <select name="mahasiswa[]" class="js-example-basic-single mahasiswa-dropdown w-full text-sm"
                            required>
                        </select>
                        <button type="button"
                            class="remove_repeater text-white inline-flex items-center gap-x-2 w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                            <span><i class="fas fa-trash"></i></span> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <x-button_md class="w-full" type="submit">
                Kirim
            </x-button_md>
        </form>
    </div>
</section>

<script>
    $(document).ready(function() {
        function initializeSelect2() {
            $('.js-example-basic-single').select2();
        }

        initializeSelect2(); // Initialize on page load

        let repeaterIndex = 2; // Start index for repeater items

        // Function to add repeater item
        $('#add_repeater').click(function() {
            const repeaterItem = `<div class="p-6 bg-slate-100 rounded-md repeater_item">
                <label for="mahasiswa_${repeaterIndex}" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa ${repeaterIndex}</label>
                <select id="mahasiswa_${repeaterIndex}" name="mahasiswa[]" class="js-example-basic-single mahasiswa-dropdown w-full" required>
                </select>
                <button type="button" class="remove_repeater text-white inline-flex items-center gap-x-2 w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                    <span><i class="fas fa-trash"></i></span> Hapus
                </button>
            </div>`;

            $('#repeater_wrapper').append(repeaterItem);
            initializeSelect2(); // Initialize Select2 for the newly added element

            // Fetch students for the newly added repeater item
            fetchMahasiswa($('#program').val(), $('#dosen').val(), $('#mahasiswa_' + repeaterIndex));

            repeaterIndex++;
        });

        // Function to remove repeater item
        $(document).on('click', '.remove_repeater', function() {
            $(this).closest('.repeater_item').remove();
        });

        // Check if both program and pamong are selected
        function checkSelections() {
            const programId = $('#program').val();
            const pamongId = $('#dosen').val();
            if (programId && pamongId) {
                fetchMahasiswa(programId, pamongId, $('.mahasiswa-dropdown'));
                $('#repeater_section').removeClass('hidden');
            } else {
                $('#repeater_section').addClass('hidden');
            }
        }

        // Event listeners for program and pamong selection
        $('#program').change(function() {
            checkSelections();
        });

        $('#dosen').change(function() {
            checkSelections();
        });

        function fetchMahasiswa(programId, pamongId, dropdown) {
            $.ajax({
                url: '{{ route('admin.peserta.lowongan') }}',
                type: 'GET',
                data: {
                    program_id: programId,
                    pamong_id: pamongId // Pass selected pamong ID as pamong_id
                },
                success: function(response) {
                    dropdown.each(function() {
                        $(this).html(''); // Clear existing options
                        $.each(response, function(key, student) {
                            $(this).append(
                                `<option value="${student.id}">${student.name} (${student.nim})</option>`
                            );
                        }.bind(this));
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                }
            });
        }
    });
</script>
@endsection
