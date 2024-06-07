@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Tambah Operator</h2>
    <form action="{{ route('admin.operator.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
        <input type="text" name="username" id="username" placeholder="Masukan Username"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ old('username') }}">
        @error('username')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
        <input type="password" name="password" id="password"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ old('password') }}" />
        @error('kategori')
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