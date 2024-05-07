@extends('layout.admin')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
    <div class="bg-white p-6 rounded-xl mt-32">
        <h2 class="text-xl font-semibold mb-4">Tambah Lowongan</h2>
        <form action="{{ route('admin.lowongan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="program" class="block text-sm font-medium text-gray-700">Program</label>
                <select name="program_id" id="program" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @foreach ($data['program'] as $program)
                        <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="tahun_akademik" class="block text-sm font-medium text-gray-700">Tahun Akademik</label>
                <select name="tahun_akademik" id="tahun_akademik" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    @php
                    $startYear = 2020;
                    $endYear = 2050;
                    @endphp
                    @for ($year = $startYear; $year <= $endYear; $year++)
                        <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }} - {{ $year + 1 }}</option>
                    @endfor
                </select>
            </div>


            <div class="mb-4">
                <label for="semester" class="block text-sm font-medium text-gray-700">Semester</label>
                <input type="text" name="semester" id="semester" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="datetime-local" name="tanggal_mulai" id="tanggal_mulai" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</section>
@endsection
