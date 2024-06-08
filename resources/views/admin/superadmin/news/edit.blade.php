@extends('layout.admin')

@section('main')
<section class="max-w-screen-lg mx-auto min-h-screen flex flex-col py-12 px-4 lg:px-12 gap-4">
  <div class="bg-white p-6 rounded-xl mt-32">
    <h2 class="text-xl font-semibold mb-4">Edit Berita</h2>
    <form action="{{ route('admin.berita.update', $news->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="mb-4">
        <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">Judul Berita</label>
        <input type="text" name="judul" id="judul" placeholder="Masukan Judul Berita"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs"
          value="{{ old('judul', $news->title) }}">
        @error('judul')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori Berita</label>
        <select name="kategori" id="kategori"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
          @foreach ($categories as $item)
          <option value="{{ $item->id }}" {{ $item->id == $news->category_id ? 'selected' : '' }}>
            {{ $item->name }}
          </option>
          @endforeach
        </select>
        @error('kategori')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="mb-4">
        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">Gambar Berita</label>
        <input type="file" name="gambar" id="gambar"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">
        @if ($news->cover)
        <img src="{{ Storage::url($news->cover) }}" alt="Current Cover" class="mt-2 h-56 w-full object-cover rounded-lg">
        @endif
      </div>
      <div class="mb-4">
        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten Berita</label>
        <textarea id="myeditorinstance" name="content"
          class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs">{{ old('content', $news->content) }}</textarea>
        @error('content')
        <div class="invalid-feedback text-red-400">
          {{ $message }}
        </div>
        @enderror
      </div>
      <x-button_md color="primary" class="w-full" type="submit">
        Update
      </x-button_md>
    </form>
  </div>
</section>
@endsection