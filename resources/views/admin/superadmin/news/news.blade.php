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
      <x-button_md type="button" class="me-2" onclick="window.location.href='{{ route('admin.berita.add') }}'">
        <span class=""><i class="fas fa-file-export text-sm me-2"></i></span>
        Tambah Data
      </x-button_md>
    </div>
  </div>
  <div class="gap-4 w-full text-sm bg-white p-6 rounded-xl" id="wrapper">
    <div class="w-full flex flex-col gap-y-4">
      <div>
        <p class="font-semibold text-lg">Filter Data</p>
      </div>
      <form action="{{ route('admin.berita') }}" method="GET">
        <div class="w-full grid grid-cols-12">
          <div class="col-span-6">
            <label for="kategori" class="block mb-2 text-xs xl:text-sm text-gray-900 dark:text-white">Kategori :</label>
            <select name="kategori" id="kategori"
              class="block w-full p-2 text-gray-900 border border-gray-300 rounded-md bg-gray-50 text-xs"
              onchange="this.form.submit()">
              <option value="">Semua kategori</option>
              @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ $selectedCategory==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
      </form>
    </div>
    <hr class="w-full mt-4 mb-4">
    <div class="overflow-x-auto lg:overflow-visible">
      <table id="table_config" class="w-full">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($data as $item)

          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item['title'] }}</td>
            <td>{{$item->category->name}}</td>
            <td>
              <div class="relative inline-block text-left">
                <x-button_sm color="info" id="dropdownMenuButton{{ $item->id }}">
                  <span><i class="fas fa-ellipsis-h"></i></span>
                </x-button_sm>

                <div id="dropdownMenu{{ $item->id }}"
                  class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden z-10"
                  role="menu" aria-orientation="vertical" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                  <div class="py-1" role="none">
                    <button type="button" onclick="window.location.href='{{ route('detail_news' , $item->id) }}'"
                      class="flex w-full items-center gap-x-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                      role="menuitem">
                      <i class="w-4 h-4 fas fa-info-circle"></i>
                      Detail
                    </button>
                    <a href="{{ route('admin.berita.edit', $item->id) }}"
                      class="flex items-center gap-x-2 px-4 py-2 text-sm text-green-500 hover:bg-gray-100 hover:text-green-700"
                      role="menuitem">
                      <i class="fas fa-pen w-4 h-4"></i>
                      Update
                    </a>
                    <form action="{{ route('admin.berita.delete', $item->id) }}" method="POST" role="none"
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
                    <x-button_sm class="inline-flex items-center gap-x-2 " color="info"
                      onclick="window.location.href='{{ route('admin.berita.edit', $item->id) }}'">
                      <span><i class="fas fa-edit"></i></span>
                      Edit
                    </x-button_sm>
                    <form action="{{ route('admin.berita.delete', $item->id) }}" method="POST" role="none"
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

        function modalOpen(button) {
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const cover = button.getAttribute('data-cover');
        const category = button.getAttribute('data-category');
        const content = button.getAttribute('data-content');
        const coverUrl = `{{ Storage::url('${cover}') }}`;

        const modal = document.getElementById('modal' + id);
        const modalContent = document.getElementById('modalContent' + id);

        modalContent.innerHTML = `
            <div class="flex flex-col gap-y-px">
                <p class="font-semibold ">Judul Berita</p>
                <p class="">${title}</p>
            </div>
            <div class="flex flex-col gap-y-px">
                <p class="font-semibold ">Kategory</p>
                <p class="">${category}</p>
            </div>
            <div class="flex flex-col gap-y-px">
                <p class="font-semibold">Cover Gambar</p>
                <img src="${coverUrl}" alt="Current Cover" class="mt-2 h-32 w-full object-cover rounded-lg">
            </div>
            <div class="flex flex-col gap-y-2">
                <p class="font-semibold">Content</p>
                <div class="max-h-56 overflow-y-auto text-xs">
                    <p class="">${content}</p>
                </div>
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
@endsection