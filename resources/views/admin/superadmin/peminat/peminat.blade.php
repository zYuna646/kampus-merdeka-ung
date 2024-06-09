@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-44 px-4 lg:px-12 gap-4">
  <div class="flex justify-between lg:flex-row flex-col lg:items-center gap-y-4">
    <h1 class="text-xl font-semibold">Peminat</h1>
    <div class="inline-flex flex-wrap gap-2">
      <x-button_md type="button" id="importBtn">
        <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
        Verifikasi
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
            <form action="{{ route('admin.peserta.import') }}" method="POST" enctype="multipart/form-data">
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
              <hr class="w-full">
              <div class="p-4 px-6 inline-flex justify-between w-full">
                <div class="inline-flex items-center gap-x-2">
                  <x-button_sm type="submit" color="primary" class="">
                    Import Data
                  </x-button_sm>
                  <x-button_sm class="inline-flex items-center gap-x-2" color="info">
                    <span><i class="fas fa-download"></i></span>
                    Template
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
      <x-button_md type="button" color="warning" class="">
        <span class=""><i class="fas fa-file-import text-sm me-2"></i></span>
        Export
      </x-button_md>
    </div>
  </div>
  <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
    <div class="overflow-x-auto lg:overflow-visible">
      <table id="table_config" class="">
        <thead>
          <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Program</th>
            <th>Tahun Akademik</th>
            <th>Semester</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)
          <tr>
            <td>{{ $item->mahasiswa->nim }}</td>
            <td>{{ $item->mahasiswa->name }}</td>
            <td>{{ $item->lokasi->name }}</td>
            <td>
              <div class="relative inline-block text-left">
                <x-button_sm color="info" id="dropdownMenuButton{{ $item->id }}">
                  <span><i class="fas fa-ellipsis-h"></i></span>
                </x-button_sm>
                <div id="dropdownMenu{{ $item->id }}"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                  role="menu" aria-orientation="vertical" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                  <div class="py-1" role="none">
                    <button onclick="modalOpen(this)"
                      class="flex items-center gap-x-2 px-4 py-2 text-sm text-color-success-500 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem">
                      <i class="w-4 h-4 fas fa-info-check"></i>
                      Verifikasi
                    </button>
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
                  <div id="modalContent{{ $item->id }}" class="w-full flex flex-col gap-y-4 mt-2 mb-4 maxh">
                    <!-- Detail data akan ditampilkan di sini -->


                  </div>
                  <hr class="w-full">
                  <div class="w-full inline-flex mt-4 gap-x-1">
                    <x-button_sm class="inline-flex items-center gap-x-2" color="info"
                      onclick="window.location.href='{{ route('admin.peserta.edit', $item->id) }}'">
                      <span><i class="fas fa-edit"></i></span>
                      Edit
                    </x-button_sm>
                    <form action="{{ route('admin.peserta.delete', $item->id) }}" method="POST" role="none"
                      style="display: inline-block;">
                      @csrf
                      @method('DELETE')
                      <x-button_sm class="inline-flex items-center gap-x-2" color="danger" type="submit">
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
          <tr>
            <td>haha</td>
            <td>eheh</td>
            <td>hiih</td>
            <td>hiih</td>
            <td>hiih</td>
            <td>
              <div class="relative inline-block text-left">
                <x-button_sm color="info" id="dropdownMenuButton1">
                  <span><i class="fas fa-ellipsis-h"></i></span>
                </x-button_sm>
                <div id="dropdownMenu1"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                  role="menu" aria-orientation="vertical" aria-labelledby="dropdownMenuButton1">
                  <div class="py-1" role="none">
                    <button onclick="modalOpen(this)"
                      class="flex w-full items-center gap-x-2 px-4 py-2 text-sm text-color-success-500 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem">
                      <i class="w-4 h-4 fas fa-check"></i>
                      Verifikasi
                    </button>
                  </div>
                </div>
            </td>
            <div id="modal1"
              class="fixed inset-0 z-20 h-screen w-screen flex justify-center items-center bg-black/25 hidden">
              <div class="max-w-lg w-full px-4">
                <div class=" w-full p-6 bg-white rounded-xl">
                  <div class="w-full inline-flex items-center justify-between">
                    <p class="text-lg font-semibold">Verifikasi Peminat</p>
                    <button class="px-3 py-1.5 rounded-lg hover:bg-slate-100 text-slate-500" onclick="closeModal('1')">
                      <i class="fas fa-times text-lg"></i>
                    </button>
                  </div>
                  <hr class="w-full mt-4">
                  <div id="modalContent1" class="w-full flex flex-col gap-y-4 mt-2 mb-4 maxh">
                    <!-- Detail data akan ditampilkan di sini -->


                  </div>
                </div>
              </div>

            </div>
          </tr>
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
            // const id = button.getAttribute('data-id');
            
            const modal = document.getElementById('modal1');
            const modalContent = document.getElementById('modalContent1');

            modalContent.innerHTML = `
              <form action="" class="">
                <div class="mb-4">
                  <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                  <select name="" id="lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    <option selected value="">
                      Lokasi 1
                    </option>
                    <!-- Ganti dengan data lokasi yang sesuai -->
                  </select>
                </div>
                <x-button_md class="w-full" color="primary" type="submit">
                  Kirim
                  </x-button_md>
              </form>
            `;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById('modal1');
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