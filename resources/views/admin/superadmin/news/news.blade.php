@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  @if (session('success'))
  <x-alerts color="info" :text="session('success')" />
  @endif

  @if (session('error'))
  <x-alerts color="info" :text="session('error')" />
  @endif
  <div class="flex justify-between lg:flex-row flex-col gap-y-4 lg:items-center">
    <h1 class="text-xl font-semibold">Berita</h1>
    <div class="inline-flex">
      <!-- Tombol Import -->
      <x-button_md type="button" class="me-2" onclick="window.location.href='{{ route('admin.faculties.add') }}'">
        <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
        Tambah Data
      </x-button_md>
      <x-button_md type="button" id="importBtn">
        <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
        Import
      </x-button_md>
      <!-- Modal Form Import -->
      <div id="importModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <!-- Konten Modal -->
          <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.faculties.import') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900">Import Data</h3>
                    <div class="mt-2">
                      <input id="import-file" type="file" name="file" class="hidden" accept=".xls, .xlsx"
                        onchange="updateFileName(this)">
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
              <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-x-2">
                <x-button_md type="submit" color="primary" class="">
                  Import Data
                </x-button_md>
                <x-button_md type="button" id="cancelImport" color="danger-outlined">
                  Batal
                </x-button_md>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Tombol Export -->
      <x-button_md type="button" color="warning" class="ms-2">
        <span class=""><i class="fas fa-file-import text-sm me-2"></i></span>
        Export
      </x-button_md>
    </div>
  </div>
  <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
    <table id="table_config" class="w-full">
      <thead>
        <tr>
          <th>Code</th>
          <th>Nama</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>

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