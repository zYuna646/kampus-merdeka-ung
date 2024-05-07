@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Guru</h2>
        <form action="{{ route('admin.guru.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                <input type="text" name="nip" id="nip" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="nama" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                <select name="lokasi_id[]" id="lokasi" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required multiple>
                    @foreach ($data as $item)
                        <option value={{$item->id}}>{{$item->name}}</option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</section>
@endsection
