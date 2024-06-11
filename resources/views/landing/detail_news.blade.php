@extends('layout.landing')

@section('main')
<section class="max-w-screen-xl mx-auto min-h-screen grid grid-cols-12 gap-4 py-32 lg:py-36">
  <div class="col-span-12 lg:col-span-8 px-2">
    <div class="">
      <img src="{{ Storage::url($data->cover) }}" alt="" class="rounded-lg w-full h-96 object-cover">
    </div>
    <div class="mt-6 font-bold text-2xl">
      <h1>{{ $data->title }} </h1>
    </div>
    <div class="mt-4">
      {!! $data->content !!}
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

</script>
@endsection