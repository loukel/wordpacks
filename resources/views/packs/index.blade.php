@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card">
    <div class="card-header h4">
      Packs
    </div>
    <div class="card-body">
      <div class="row">

        @foreach($packs as $pack)
          <br>
          <div class="col-sm-4 py-2 pack">
            <div class="card card-body h-100">
              <div class="h3 label" contenteditable="true"
                onfocusout="updateLabel({{ $pack['id'] }})">
                {{ $pack['label'] }}
              </div>
              <button class="btn btn-dark"
                onClick="window.location = '{{ route('packs.show', $pack['id'] ) }}'">Open</button>
            </div>
          </div>
        @endforeach


      </div>
    </div>
  </div>
</div>

<script>
  function updateLabel(id) {
    console.log("Updated" + id);
  }

  function createNew() {
    console.log("New pack created")
  }

</script>
{{-- {{-- <button class="btn btn-success update mb-1">Update label</button> --}}
@endsection
