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
      <x-button_md type="button" class="me-2" onclick="window.location.href='{{ route('admin.kategori.add') }}'">
        <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
        Tambah Data
      </x-button_md>
    </div>
  </div>
  <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
    <div class="overflow-x-auto lg:overflow-visible">
      <table id="table_config" class="w-full">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)

          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['name'] }}</td>
            <td>
              <div class="relative inline-block text-left">
                <x-button_sm color="info" id="dropdownMenuButton{{ $item->id }}">
                  <span><i class="fas fa-ellipsis-h"></i></span>
                </x-button_sm>

                <div id="dropdownMenu{{ $item->id }}"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                  role="menu" aria-orientation="vertical" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                  <div class="py-1" role="none">
                    <a href="{{ route('admin.guru.show', $item->id) }}"
                      class="flex items-center gap-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem">
                      <i class="w-4 h-4 fas fa-info-circle"></i>
                      Detail
                    </a>
                    <a href="{{ route('admin.kategori.edit', $item->id) }}"
                      class="flex items-center gap-x-2 px-4 py-2 text-sm text-green-500 hover:bg-gray-100 hover:text-green-700"
                      role="menuitem">
                      <i class="fas fa-pen w-4 h-4"></i>
                      Update
                    </a>
                    <form action="{{ route('admin.kategori.delete', $item->id) }}" method="POST" role="none"
                      class="w-full" style="display: inline-block;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" onclick="return confirm('Are you sure you want to delete?')"
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