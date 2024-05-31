@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Peserta</h2>
        <form action="{{ route('admin.peserta.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                <select name="lowongan_id" id="lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['program'] as $item)
                    <option value="{{ $item->id }}">{{$item->program->name . ' (' . $item->tahun_akademik . ')' }}
                    </option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" id="lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['mahasiswa'] as $item)
                    <option value="{{ $item->id }}">{{ $item->nim . ' - ' . $item->name }}</option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <select name="lokasi_id" lokasi"
                    class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                    required>
                    @foreach ($data['lokasi'] as $item)
                    <option value="{{ $item->id }}">{{$item->name }}</option>
                    @endforeach
                    <!-- Ganti dengan data lokasi yang sesuai -->
                </select>
            </div>

            <button type="submit"
                class="text-white w-full h-full bg-color-primary-500 hover:bg-color-primary-600  font-medium rounded-lg text-sm px-5 py-2.5 col-span-12 mt-2">
                Kirim
            </button>
        </form>
    </div>
</section>
@endsection