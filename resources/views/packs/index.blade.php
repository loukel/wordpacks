@extends('layouts.app')

@section('content')

<div class="container">
  <div class="card">
    <div class="card-header h4">
      Packs
      <a class="create" onclick="createNew()"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-plus"
          fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd"
            d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z" />
          <path fill-rule="evenodd"
            d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
        </svg></a>
    </div>
    <div class="card-body">
      <div class="row">

        <div class="col-sm-4 py-2 pack">
          <div class="card card-body h-100">
            <div class="h3 label" contenteditable="true" onfocusout="updateLabel(1)">Pack 1 Pack 1 Pack 1 Pack 1 Pack 1
            </div>
            {{-- <button class="btn btn-success update mb-1">Update label</button> --}}
            <button class="btn btn-dark"
              onClick="window.location = '{{ route('packs.show', 1) }}'">Open</button>
          </div>
        </div>
        <div class="col-sm-4 py-2 pack">
          <div class="card card-body h-100">
            <div class="h3 label" contenteditable="true" onfocusout="updateLabel(1)">Pack 1
            </div>
            {{-- <button class="btn btn-success update mb-1">Update label</button> --}}
            <button class="btn btn-dark"
              onClick="window.location = '{{ route('packs.show', 2) }}'">Open</button>
          </div>
        </div>

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

@endsection
