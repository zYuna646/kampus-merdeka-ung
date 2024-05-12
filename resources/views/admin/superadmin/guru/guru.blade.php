@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
    <div class="flex justify-between lg:flex-row flex-col lg:items-center gap-y-4">
        <h1 class="text-xl font-semibold">Mitra</h1>
        <div class="inline-flex flex-wrap">
            <a href="{{ route('admin.guru.add') }}"
                class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                <span><i class="fas fa-file-export text-sm me-2"></i></span>
                Tambah Data
            </a>

            <!-- Tombol Import -->
            <button type="button" id="importBtn"
                class="text-white h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 focus:ring-color-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
                Import
            </button>

            <!-- Modal Form Import -->
            <div id="importModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <!-- Konten Modal -->
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data">
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
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-color-primary-500 text-base font-medium text-white hover:bg-color-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-color-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Import Data
                                </button>
                                <button type="button" id="cancelImport"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tombol Export -->
            <a type="button"  href="{{route('admin.guru.export')}}"
                class="text-white h-full bg-color-warning-500 hover:bg-color-warning-600 focus:ring-4 focus:ring-color-warning-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                <span class=""><i class="fas fa-file-import text-sm me-2"></i></span>
                Export
        </a>
        </div>
    </div>
    <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
        <table id="table_config" class="">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item['nik'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>
                        <ul>
                            @foreach ($item->lokasis as $index => $lokasi)
                            <li> {{ $index + 1 . '. ' . $lokasi->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <div class="relative inline-block text-left">
                            <button type="button" id="dropdownMenuButton{{ $item->id }}"
                                class="inline-flex justify-center items-center w-full rounded-md px-2 py-1 bg-blue-500 text-white hover:bg-blue-600"
                                aria-expanded="false" aria-haspopup="true">
                                <!-- Tanda tiga titik vertikal (ellipsis) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm6 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="dropdownMenu{{ $item->id }}"
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                                role="menu" aria-orientation="vertical"
                                aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                <div class="py-1" role="none">
                                    <a href="{{ route('admin.guru.show', $item->id) }}"
                                        class="flex items-center gap-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                        role="menuitem">
                                        <i class="w-4 h-4 fas fa-info-circle"></i>
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.guru.edit', $item->id) }}"
                                        class="flex items-center gap-x-2 px-4 py-2 text-sm text-green-500 hover:bg-gray-100 hover:text-green-700"
                                        role="menuitem">
                                        <i class="fas fa-pen w-4 h-4"></i>
                                        Update
                                    </a>
                                    <form action="{{ route('admin.guru.delete', $item->id) }}" method="POST" role="none"
                                        style="display: inline-block;">
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



                </tr>
                @endforeach
            </tbody>
        </table>
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
