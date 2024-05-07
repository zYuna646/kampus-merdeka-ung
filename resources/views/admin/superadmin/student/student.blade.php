@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold">Mahasiswa</h1>
        <div class="inline-flex">
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
                        <form action="{{ route('admin.student.import') }}" method="POST"
                            enctype="multipart/form-data">
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
            <button type="button"
                class="text-white h-full bg-color-warning-500 hover:bg-color-warning-600 focus:ring-4 focus:ring-color-warning-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                <span class=""><i class="fas fa-file-import text-sm me-2"></i></span>
                Export
            </button>
        </div>
    </div>
    <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
        <table id="table_config" class="">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $item['nim'] }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item->studi->name }}</td>
                    <td>{{ $item['angkatan']  }}</td>

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
   $(document).ready( function () {
    $('#table_config').DataTable();
} );
</script>
@endsection
