@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Edit Peserta</h2>
        <form action="{{ route('admin.peserta.update', $peserta->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="lowongan_id" id="lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['program'] as $item)
                    <option value="{{ $item->id }}" {{ $item->id === $peserta->program_id }}>{{$item->program->name . ' (' . $item->tahun_akademik . ')' }}
                    </option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" id="lokasi" 
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required >
                    <option value="{{ $peserta->mahasiswa->id }}" selected>{{ $peserta->mahasiswa->nim . ' - ' . $peserta->mahasiswa->name }}</option>
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select name="lokasi_id"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['lokasi'] as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $peserta->lokasi->id ? 'selected' : '' }}>{{$item->name }}</option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <x-button_md color="primary" class="w-full" type="submit">
                Kirim
            </x-button_md>
        </form>
    </div>
</section>
@endsection