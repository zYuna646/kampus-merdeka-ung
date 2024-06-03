@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Edit Jurusan</h2>
    <form action="{{ route('admin.departement.update', $jurusan->id) }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Jurusan</label>
        <input type="text" name="name" id="nama" placeholder="Masukan Nama Jurusan"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required value="{{ $jurusan->name }}">
      </div>
      <div class="mb-4">
        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Kode Jurusan</label>
        <input type="text" name="code" id="code" placeholder="Masukan Nama Jurusan"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" value="{{ $jurusan->code }}">
        @error('code')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        @csrf
        <label for="fakultas_id" class="block text-sm font-medium text-gray-700 mb-2">Nama Fakultas</label>
        <select type="text" name="fakultas_id" id="fakultas_id" placeholder="Masukan Nama Fakultas"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          required>
          @foreach ($fakultases as $fakultas)
          <option value="{{ $fakultas->id }}" {{ $fakultas->id === $jurusan->fakultas_id ? 'selected' : '' }}>{{
            $fakultas->name }}</option>
          @endforeach
        </select>
      </div>
      <x-button_md color="primary" class="w-full" type="submit">
        Kirim
      </x-button_md>
    </form>
  </div>
</section>
@endsection