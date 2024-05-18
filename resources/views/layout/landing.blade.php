@extends('default')

@section('body')
<x-landingnav />
<main class="font-Poppins">
  @yield('main')
</main>
<x-landingfooter />
@endsection