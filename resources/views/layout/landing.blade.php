@extends('default')

@section('body')
<x-landingnav />
<main class="font-Poppins">
  @yield('main')
</main>
<div class="isolated fixed z-20 bottom-6 right-6">
  <button class="p-2 px-3.5 w-12 h-12 rounded-full bg-color-primary-500 text-white" id="scroll-top">
    <span><i class="fas fa-arrow-up"></i></span>
  </button>
</div>
<x-landingfooter />
<script>
  document.getElementById('scroll-top').addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth' // Menggulir dengan animasi halus
    });
  });
</script>
@endsection