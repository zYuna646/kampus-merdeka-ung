@extends('layout.admin')

@section('main')
    <style>
        /* Add any custom styles here */
    </style>
    <section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
        <div class="bg-white p-8 rounded-xl mt-32">
            <h2 class="text-xl font-semibold mb-4">Tambah DPL</h2>
            <form action="{{ route('admin.dpl.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="dosen" class="block text-sm font-medium text-gray-700 mb-2">Dosen</label>
                    <select name="dosen_id" id="dosen"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                        <option selected value="{{ $data['dpl']->dosen->id }}">
                            {{ $data['dpl']->dosen->nidn . ' - ' . $data['dpl']->dosen->name }}</option>
                        <!-- Add more options dynamically as needed -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="lowongan" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                    <select name="lowongan_id" id="lowongan"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                        <option value="" disabled selected>Pilih Program</option>
                        @foreach ($data['lowongan'] as $lowongan)
                            <option value="{{ $lowongan->id }}">
                                {{ $lowongan->program->name . ' (' . $lowongan->tahun_akademik . ') - ' . $lowongan->semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 flex flex-col gap-y-4" id="repeater_section" style="display: none;">
                    <div class="flex items-end justify-between">
                        <p class="block text-sm font-medium text-gray-700">Tambah Mahasiswa</p>
                        <x-button_sm color="primary" id="add_repeater">
                            <span><i class="fas fa-plus"></i></span>
                        </x-button_sm>
                    </div>
                    <div id="repeater_wrapper" class="flex flex-col gap-y-4">
                        <!-- Repeater items will be added here -->
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

            let repeaterIndex = 1; // Start index for repeater items

            // Function to add repeater item
            $('#add_repeater').click(function() {
                const repeaterItem = `<div class="p-6 bg-slate-100 rounded-md repeater_item">
                <label for="mahasiswa_${repeaterIndex}" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa ${repeaterIndex}</label>
                <select id="mahasiswa_${repeaterIndex}" name="mahasiswa[]" class="js-example-basic-single w-full" required>
                    <!-- Options will be populated based on selected lowongan -->
                </select>
                <button type="button" class="remove_repeater text-white inline-flex items-center gap-x-2 w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                    <span><i class="fas fa-trash"></i></span> Hapus
                </button>
            </div>`;

                $('#repeater_wrapper').append(repeaterItem);
                initializeSelect2(); // Initialize Select2 for the newly added element
                repeaterIndex++;
            });

            // Function to remove repeater item
            $(document).on('click', '.remove_repeater', function() {
                $(this).closest('.repeater_item').remove();
            });

            // Fetch students based on selected lowongan
            $('#lowongan').change(function() {
                const lowonganId = $(this).val();
                if (lowonganId) {
                    fetchStudents(lowonganId);
                }
            });

            function fetchStudents(lowonganId) {
    $.ajax({
        url: '/dashboard/admin/peserta/get/lokasi', // Adjust this URL to your API endpoint
        type: 'GET',
        data: {
            lowongan_id: lowonganId
        },
        success: function(data) {
            console.log(data);
            $('#repeater_wrapper select').each(function() {
                const select = $(this);
                const selectedValue = select.val(); // Save the current selected value
                select.empty(); // Clear the current options
                $.each(data, function(index, student) {
                    // Ensure each student object has 'id', 'name', and 'nim' properties
                    const option = new Option(student.name + ' (' + student.nim + ')', student.id);
                    select.append(option);
                });
                select.val(selectedValue); // Restore the selected value
                select.trigger('change'); // Trigger change event to re-initialize Select2
            });
            $('#repeater_section').show(); // Show repeater section
        },
        error: function() {
            alert('Failed to fetch students. Please try again.');
        }
    });
}


            function updateStudentOptions(students) {

            }


            // Initialize on page load with the selected lowongan
            const initialLowonganId = $('#lowongan').val();
            if (initialLowonganId) {
                fetchStudents(initialLowonganId);
            }
        });
    </script>
@endsection
