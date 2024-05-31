@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Guru</h2>
        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                <input type="number" name="nip" id="nip" placeholder="Masukan NIP"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="nama" placeholder="Masukan Nama"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <select name="lokasi_id[]" multiple class="js-example-basic-multiple w-full text-smgit add ." required>
                    @foreach ($data as $item)
                    <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <x-button_md color="primary" class="w-full" type="submit">
                Kirim
            </x-button_md>
        </form>
    </div>
</section>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection