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
        Berita Terpopuler
      </h2>
      <div class="grid grid-flow-row divide-y-[1px]">
        <div class="p-4 bg-white  grid grid-cols-12 gap-4">
          <div class="col-span-6 rounded-lg">
            <img src="/images/hero-image/image.png" alt="" class="rounded-md w-full h-24 object-cover">
          </div>
          <div class="col-span-6 flex flex-col gap-y-2">
            <a href="" class="text-sm font-semibold news-title">Lorem ipsum dolor sit amet consectetur, adipisicing
              elit.</a>
            <p class="text-sm text-slate-500">14 Juni 2023</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>

</script>
@endsection