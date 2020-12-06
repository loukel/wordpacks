@extends('layouts.app')

@section('content')

<div class="container">
  <div class="h1 text-center">Label for {{ $id }}</div>
  <div class="card">
    <h5 class="card-header">Malign</h5>
    <div class="card-body">
      <h5 class="card-subtitle font-italic">adjective</h5>
      <p class="card-text definition">evil in nature or effect</p>
      <h5 class="card-subtitle font-italic">verb</h5>
      <p class="card-text definition">speak about (someone) in a spitefully critical manner.</p>
    </div>
  </div>
</div>

@endsection
