@extends('layouts.app')

@section('content')

<div class="container">
  <div class="btn btn-dark back" onClick="window.location = '{{ route('packs.index') }}'">
    back</div>
  <div class="h1 text-center">Label for {{ $id }}
  </div>
  <div class="card mb-3">
    <h5 class="card-header">Malign</h5>
    <div class="card-body">
      <div class="sense mb-3">
        <h5 class="card-subtitle font-italic">adjective</h5>
        <p class="card-text">evil in nature or effect</p>
        <p class="card-text">evil in nature or effect</p>
      </div>
      <div class="sense">
        <h5 class="card-subtitle font-italic">verb</h5>
        <p class="card-text">speak about (someone) in a spitefully critical manner.</p>
      </div>
    </div>
  </div>

</div>

@endsection
