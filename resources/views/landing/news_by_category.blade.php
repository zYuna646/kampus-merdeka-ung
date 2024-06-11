@extends('layout.landing')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
  <div class="col-span-12 lg:col-span-8 px-2">
    <div>
      <h2 class="text-2xl font-semibold text-color-primary-500 px-4">
        Berita Kategori: {{ $category->name }}
      </h2>
    </div>
    <div class="flex items-center justify-center gap-x-4 px-4 mt-6 mb-2">
      <input name="dosen_id" id="lokasi" placeholder="Cari Berita"
        class="block w-full xl:p-4 p-3 text-gray-900 border border-gray-300 rounded-md bg-gray-50 xl:text-sm text-xs" />
      <button type="button" id="add_repeater"
        class="text-white w-fit h-full bg-color-primary-500 hover:bg-color-primary-600 focus:ring-4 font-medium rounded-lg text-sm px-5 py-4 col-span-12">
        <span><i class="fas fa-search"></i></span>
      </button>
    </div>
    <div class="grid grid-flow-row">
      @foreach ($data as $item)
      <div class="p-4 grid grid-cols-12 lg:gap-4 gap-2">
        <a href="{{ route('detail_news', $item->id) }}" class="col-span-12 lg:col-span-6">
          <img src='{{ Storage::url($item->cover) }}' alt="" class="rounded-lg w-full object-cover lg:h-56 h-36">
        </a>
        <div class="col-span-12 lg:col-span-6 flex flex-col justify-between py-2 gap-y-4">
          <a href="{{ route('detail_news', $item->id) }}" class="flex flex-col gap-y-4">
            <p class="font-semibold lg:text-lg news-title">{{$item->title}}</p>
            <p class="text-xs lg:text-sm truncate-text" data-text="{{ $item->content }}"></p>
          </a>
          <div>
            <p class="text-sm text-slate-500">{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
            <a href="{{ route('news_by_category', $item->category->name) }}"
              class="uppercase font-semibold text-sm text-color-primary-500">{{ $item->category->name}}</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="px-4">
      <!-- Pagination (if any) -->
    </div>
  </div>
  <div class="col-span-12 lg:col-span-4 flex flex-col gap-y-4 px-2">
    <div>
      <h2 class="font-semibold text-lg px-4">
        Berita Terbaru
      </h2>
      <div class="grid grid-flow-row divide-y-[1px]">
        @foreach ($latestNews as $item)
        <a href="{{ route('detail_news', $item->id) }}" class="p-4 bg-white grid grid-cols-12 gap-4">
          <div class="col-span-6 rounded-lg">
            <img src='{{ Storage::url($item->cover) }}' alt="" class="rounded-md w-full h-24 object-cover">
          </div>
          <div class="col-span-6 flex flex-col gap-y-2">
            <p class="text-sm font-semibold news-title">{{ $item->title
              }}</p>
            <p class="text-sm text-slate-500">{{ Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const truncateTextElements = document.querySelectorAll('.truncate-text');
      const truncateTextLength = 200; // Set the length for truncating

      truncateTextElements.forEach(function(element) {
          const fullText = element.getAttribute('data-text');
          const plainText = fullText.replace(/<\/?[^>]+(>|$)/g, ""); // Remove HTML tags
          if (plainText.length > truncateTextLength) {
              const truncatedText = plainText.substring(0, truncateTextLength) + '...';
              element.textContent = truncatedText;
          } else {
              element.textContent = plainText;
          }
      });
  });
</script>
@endsection