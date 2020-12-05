@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card">
    <div class="card-header h4">
      Packs
    </div>
    <div class="card-body">
      <div class="row">

        <div class="col-sm-4 py-2 pack">
          <div class="card card-body h-100">
            <div class="h3">Pack 1</div>
            <button class="btn btn-dark"
              onClick="window.location = '{{ route('packs.show', 1) }}'">Open</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
