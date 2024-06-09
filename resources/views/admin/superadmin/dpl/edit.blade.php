@extends('layout.admin')

@section('main')
    <style>

    </style>
    <section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
        <div class="bg-white p-8 rounded-xl mt-32">
            <h2 class="text-xl font-semibold mb-4">EDIT DPL</h2>
            <form action="{{ route('admin.dpl.update', $data['dpl']->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Dosen</label>
                    <select name="dosen_id" id="lokasi" disabled
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required>
                        <option selected value="{{ $data['dpl']->dosen->id }}">
                            {{ $data['dpl']->dosen->nidn . ' - ' . $data['dpl']->dosen->name }}</option>
                        <!-- Ganti dengan data lokasi yang sesuai -->
                    </select>
                </div>
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                    <select name="lowongan_id" id="lokasi"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        required disabled>
                        <option selected value="{{ $data['dpl']->lowongan->id }}">
                            {{ $data['dpl']->lowongan->program->name . ' (' . $data['dpl']->lowongan->tahun_akademik . ') - ' . $data['dpl']->lowongan->semester }}
                        </option>
                        <!-- Ganti dengan data lokasi yang sesuai -->
                    </select>
                </div>
                <div class="mb-4 flex flex-col gap-y-4">
                    <div class="flex items-end justify-between">
                        <p class="block text-sm font-medium text-gray-700">Tambah Mahasiswa</p>

                        <x-button_sm color="primary" id="add_repeater">
                            <span><i class="fas fa-plus"></i></span>
                        </x-button_sm>
                    </div>
                    <div id="repeater_wrapper" class="flex flex-col gap-y-4">
                        @foreach ($data['dpl']->mahasiswa as $index => $mahasiswa)
                            <div class="p-6 bg-slate-100 rounded-md repeater_item">
                                <label for="mahasiswa_{{ $index }}" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa {{ $index + 1 }}</label>
                                <select name="mahasiswa[]" class="js-example-basic-single w-full text-sm" required>
                                    @foreach ($data['mahasiswa'] as $item)
                                        <option value="{{ $item->id }}" {{ $mahasiswa->id == $item->id ? 'selected' : '' }}>
                                            {{ $item->mahasiswa->name . '(' . $item->mahasiswa->nim . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" class="remove_repeater text-white inline-flex items-center gap-x-2 w-fit bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-4">
                                    <span><i class="fas fa-trash"></i></span> Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>
                    
                </div>
                <x-button_md class="w-full" type="submit" type="submit">
                    Kirim
                </x-button_md>
            </form>
        </div>

    </section>
    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('.js-example-basic-multiple').select2();
            }

        initializeSelect2(); // Initialize on page load

            let repeaterIndex = 2; // Start index for repeater items

            // Function to add repeater item
            $('#add_repeater').click(function() {
                const repeaterItem = `<div class="p-6 bg-slate-100 rounded-md repeater_item">
                <label for="mahasiswa_${repeaterIndex}" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa ${repeaterIndex}</label>
                <select id="mahasiswa_${repeaterIndex}"
                     name="mahasiswa[]"
                    class="js-example-basic-single w-full "
                    required>
                     @foreach ($data['mahasiswa'] as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->mahasiswa->name . '(' . $item->mahasiswa->nim . ')' }}
                                        </option>
                                    @endforeach
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
@endsection
