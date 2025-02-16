@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
    @if (session('success'))
    <x-alerts color="info" :text="session('success')" />
    @endif

    @if (session('error'))
    <x-alerts color="danger" :text="session('error')" />
    @endif
    <div class="flex justify-between lg:flex-row flex-col lg:items-center gap-y-4">
        <h1 class="text-xl font-semibold">Lokasi</h1>
        <div class="inline-flex gap-2 flex-wrap">
            {{-- <a href="{{ route('admin.location.add') }}"
                class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                <span><i class="fas fa-file-export text-sm me-2"></i></span>
                Tambah Data
            </a> --}}


            <!-- Tombol Import -->
            <x-button_md type="button" class="" onclick="window.location.href='{{ route('admin.location.add') }}'">
                <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
                Tambah Data
            </x-button_md>

            <x-button_md type="button" id="importBtn">
                <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
                Import
            </x-button_md>

            

            <form action="{{ route('admin.location.export') }}" method="POST">
                @csrf
                <input type="hidden" name="data" value="{{ json_encode($data) }}">
                
                <x-button_md type="submit" color="warning" class="">
                    <span><i class="fas fa-file-import text-sm me-2"></i></span>
                    Export
                </x-button_md>
            </form>

            <!-- Modal Form Import -->
            <div id="importModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <!-- Konten Modal -->
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('admin.location.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg font-medium text-gray-900">Import Data</h3>
                                        <div class="mt-2">
                                            <input id="import-file" type="file" name="file" class="hidden"
                                                accept=".xls, .xlsx" onchange="updateFileName(this)">
                                            <label for="import-file" class="cursor-pointer">
                                                <span
                                                    class="text-white bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center"
                                                    id="fileLabel">
                                                    <i class="fas fa-file-export text-sm me-2"></i>
                                                    Pilih File Excel (.xls, .xlsx)
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="w-full">
                            <div class="p-4 px-6 inline-flex justify-between w-full">
                                <div class="inline-flex items-center gap-x-2">
                                    <x-button_sm type="submit" color="primary" class="">
                                        Import Data
                                    </x-button_sm>
                                    <x-button_sm class="inline-flex items-center gap-x-2" color="info">
                                        <a href="{{ asset('templates/lokasi_template.xlsx') }}" download>
                                            <span><i class="fas fa-download"></i></span>
                                            Template
                                        </a>
                                    </x-button_sm>
                                </div>
                                <div>
                                    <x-button_sm type="button" id="cancelImport" color="danger-outlined">
                                        Batal
                                    </x-button_sm>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tombol Export -->
        </div>
    </div>
    <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
        <div class="w-full flex flex-col gap-y-4">
            <div>
                <p class="font-semibold text-lg">Filter Data</p>
            </div>
            <form action="{{ route('admin.location') }}" method="GET">
                <div class="w-full grid grid-cols-10 gap-4">
                    <div class="col-span-2">
                        <label for="program" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Program
                            :</label>
                        <select id="program" name="program"
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs"
                            onchange="this.form.submit()">
                            <option value="">Semua Program</option>
                            @foreach ($programs as $program)
                            <option value="{{ $program->program->id }}">{{ $program->program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="provinsi"
                            class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Provinsi :</label>
                        <select id="provinsi" name="provinsi"
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs"
                            onchange="this.form.submit()">
                            <option value="">Semua Provinsi</option>
                            @foreach ($provinsis as $provinsi)
                            <option value="{{ $provinsi->provinsi->id }}">{{ $provinsi->provinsi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="kabupaten"
                            class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Kabupaten :</label>
                        <select id="kabupaten" name="kabupaten"
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs"
                            onchange="this.form.submit()">
                            <option value="">Semua kabupaten</option>
                            @foreach ($kabupatens as $kabupaten)
                            <option value="{{ $kabupaten->kabupaten->id }}">{{ $kabupaten->kabupaten->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="kecamatan"
                            class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Kecamatan :</label>
                        <select id="kecamatan" name="kecamatan"
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs"
                            onchange="this.form.submit()">
                            <option value="">Semua kecamatan</option>
                            @foreach ($kecamatans as $kecamatan)
                            <option value="{{ $kecamatan->kecamatan->id }}">{{ $kecamatan->kecamatan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label for="kelurahan"
                            class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Kelurahan :</label>
                        <select id="kelurahan" name="kelurahan"
                            class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50  text-xs"
                            onchange="this.form.submit()">
                            <option value="">Semua kelurahan</option>
                            @foreach ($kelurahans as $kelurahan)
                            <option value="{{ $kelurahan->kelurahan->id }}">{{ $kelurahan->kelurahan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <hr class="w-full mt-4 mb-4">
        <div class="overflow-x-auto lg:overflow-visible">
            <table id="table_config" class="stripe row-border cell-border">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Nama</th>
                        <th>Progam</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Kecamatan</th>
                        <th>Kelurahan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td>{{ $item['code'] }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item->program->name }}</td>
                        <td>{{ $item->provinsi->name }}</td>
                        <td>{{ $item->kabupaten->name }}</td>
                        <td>{{ $item->kecamatan->name }}</td>
                        <td>{{ $item->kelurahan->name }}</td>
                        <td>
                            <div class="relative inline-block text-left">
                                <x-button_sm color="info" id="dropdownMenuButton{{ $item->id }}">
                                    <span><i class="fas fa-ellipsis-h"></i></span>
                                </x-button_sm>

                                <div id="dropdownMenu{{ $item->id }}"
                                    class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                                    role="menu" aria-orientation="vertical"
                                    aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                    <div class="py-1" role="none">
                                        <button data-id="{{ $item->id }}" data-code="{{ $item->code }}"
                                            data-name="{{ $item->name }}" data-program="{{ $item->program->name }}"
                                            data-provinsi="{{ $item->provinsi->name }}"
                                            data-kabupaten="{{ $item->kabupaten->name }}"
                                            data-kecamatan="{{ $item->kecamatan->name }}"
                                            data-kelurahan="{{ $item->kelurahan->name }}" onclick="modalOpen(this)"
                                            class="flex w-full items-center gap-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                            role="menuitem">
                                            <i class="w-4 h-4 fas fa-info-circle"></i>
                                            Detail
                                        </button>
                                        <a href="{{ route('admin.location.edit', $item->id) }}"
                                            class="flex items-center gap-x-2 px-4 py-2 text-sm text-green-500 hover:bg-gray-100 hover:text-green-700"
                                            role="menuitem">
                                            <i class="fas fa-pen w-4 h-4"></i>
                                            Update
                                        </a>
                                        <form action="{{ route('admin.location.delete', $item->id) }}" method="POST"
                                            class="w-full" role="none" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete?')"
                                                class="flex w-full gap-x-2 items-center px-4 py-2 text-sm text-red-500 hover:bg-gray-100 hover:text-red-700"
                                                role="menuitem">
                                                <i class="fas fa-trash w-4 h-4"></i>
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </td>
                        <div id="modal{{ $item->id }}"
                            class="fixed inset-0 z-20 h-screen w-screen flex justify-center items-center bg-black/25 hidden">
                            <div class="max-w-lg w-full px-4">
                                <div class=" w-full p-6 bg-white rounded-xl">
                                    <div class="w-full inline-flex items-center justify-between">
                                        <p class="text-lg font-semibold">Detail</p>
                                        <button class="px-3 py-1.5 rounded-lg hover:bg-slate-100 text-slate-500"
                                            onclick="closeModal('{{ $item->id }}')">
                                            <i class="fas fa-times text-lg"></i>
                                        </button>
                                    </div>
                                    <hr class="w-full mt-4">
                                    <div id="modalContent{{ $item->id }}"
                                        class="w-full flex flex-col gap-y-4 mt-2 mb-4 maxh">
                                        <!-- Detail data akan ditampilkan di sini -->


                                    </div>
                                    <hr class="w-full">
                                    <div class="w-full inline-flex mt-4 gap-x-1">
                                        <x-button_sm class="inline-flex items-center gap-x-2" color="info"
                                            onclick="window.location.href='{{ route('admin.location.edit', $item->id) }}'">
                                            <span><i class="fas fa-edit"></i></span>
                                            Edit
                                        </x-button_sm>
                                        <form action="{{ route('admin.location.delete', $item->id) }}" method="POST"
                                            role="none" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <x-button_sm class="inline-flex items-center gap-x-2" color="danger"
                                                type="submit">
                                                <span><i class="fas fa-trash"></i></span>
                                                Hapus
                                            </x-button_sm>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</section>
<script>
    const importBtn = document.getElementById('importBtn');
        const importModal = document.getElementById('importModal');
        const cancelImport = document.getElementById('cancelImport');

        importBtn.addEventListener('click', () => {
            importModal.classList.remove('hidden');
            document.body.classList.add('modal-open');
        });

        cancelImport.addEventListener('click', () => {
            importModal.classList.add('hidden');
            document.body.classList.remove('modal-open');
        });

        function updateFileName(input) {
            const fileLabel = document.getElementById('fileLabel');
            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                fileLabel.innerHTML = `<i class="fas fa-file-export text-sm me-2"></i>${fileName}`;
            } else {
                fileLabel.innerHTML = `<i class="fas fa-file-export text-sm me-2"></i>Pilih File Excel (.xls, .xlsx)`;
            }
        }
        function modalOpen(button) {
            const id = button.getAttribute('data-id');
            const code = button.getAttribute('data-code');
            const name = button.getAttribute('data-name');
            const program = button.getAttribute('data-program');
            const provinsi = button.getAttribute('data-provinsi');
            const kabupaten = button.getAttribute('data-kabupaten');
            const kecamatan = button.getAttribute('data-kecamatan');
            const kelurahan = button.getAttribute('data-kelurahan');

            const modal = document.getElementById('modal' + id);
            const modalContent = document.getElementById('modalContent' + id);

            const formatAddress = (provinsi, kabupaten, kecamatan, kelurahan) => {
                return `${kelurahan}, ${kecamatan}, ${kabupaten}, ${provinsi}`;
            }

            const address = formatAddress(provinsi, kabupaten, kecamatan, kelurahan);

            modalContent.innerHTML = `
                <div class="flex flex-col gap-y-px">
                    <p class="font-semibold ">Kode Lokasi</p>
                    <p class="">${code}</p>
                </div>
                <div class="flex flex-col gap-y-px">
                    <p class="font-semibold ">Nama Lokasi</p>
                    <p class="">${name}</p>
                </div> 
                <div class="flex flex-col gap-y-px">
                    <p class="font-semibold ">alamat</p>
                    <p class="">${address}</p>
                </div> 
            `;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById('modal' + id);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
</script>
<script src="https://cdn.datatables.net/2.0.6/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
            $('#table_config').DataTable();
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            const dropdownButtons = document.querySelectorAll('[id^="dropdownMenuButton"]');
            dropdownButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    const dropdownId = this.getAttribute('id').replace('dropdownMenuButton', '');
                    const dropdownMenu = document.getElementById('dropdownMenu' + dropdownId);
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';

                    // Menutup semua dropdown yang sedang terbuka
                    document.querySelectorAll('.origin-top-right').forEach(function(dropdown) {
                        dropdown.classList.add('hidden');
                    });

                    if (!isExpanded) {
                        this.setAttribute('aria-expanded', 'true');
                        dropdownMenu.classList.remove('hidden');
                    } else {
                        this.setAttribute('aria-expanded', 'false');
                        dropdownMenu.classList.add('hidden');
                    }

                    // Menghentikan event dari menyebar, memastikan dropdown lainnya tidak terbuka
                    event.stopPropagation();
                });
            });

            // Menutup dropdown saat dokumen diklik
            document.addEventListener('click', function() {
                document.querySelectorAll('.origin-top-right').forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                });
                dropdownButtons.forEach(function(button) {
                    button.setAttribute('aria-expanded', 'false');
                });
            });
        });
</script>
@endsection