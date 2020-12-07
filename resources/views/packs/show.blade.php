@extends('layouts.app')

@section('content')

<div class="container">
  <div class="btn btn-dark back" onClick="window.location = '{{ route('packs.index') }}'">
    back</div>
  <div class="h1 text-center">
    {{ $label }}
    <br>
    <small class="text-muted">Created by: {{ $creator }}</small>
  </div>
  @foreach(array_keys($words) as $word)
    <div class="card mb-3">
      <h5 class="card-header">{{ $word }}</h5>
      <div class="card-body">
        @foreach($words[$word] as $sense)
          <div class="sense mb-3">
            <h5 class="card-subtitle font-italic">{{ $sense['pos'] }}</h5>
            @foreach($sense['definitions'] as $definition)
              <p class="card-text">{{ $definition }}</p>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</div>

@endsection
