@extends('layout.admin')

@section('main')
    <section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
        <div class="bg-white p-6 rounded-xl mt-32">
            <h2 class="text-xl font-semibold mb-4">Edit Program Kampus Merdeka</h2>
            <form action="{{ route('admin.campus_merdeka_program.update', $program->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Program</label>
                    <input type="text" name="name" id="nama" placeholder="Masukan Nama Program"
                           class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                           value="{{ old('name', $program->name) }}">
                    
                    @error('name')
                        <div class="invalid-feedback text-red-400">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Porgram</label>
                    <input type="text" name="code" id="code" placeholder="Masukan Kode Program"
                        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
                        value="{{old('code', $program->code) }}">
                    @error('code')
                        <div class="invalid-feedback text-red-400">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <x-button_md color="primary" class="w-full" type="submit">
                    Kirim
                </x-button_md>
            </form>
        </div>
    </section>
@endsection
