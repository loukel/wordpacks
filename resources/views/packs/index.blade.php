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
              <div class="btn-group">
                <div class="btn-group dropdown">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">

                  </button>
                  <div class="dropdown-menu">
                    <button class="dropdown-item btn">Edit</button>
                    <form
                      action="{{ route('packs.destroy', $pack['id']) }}"
                      method="post">
                      @csrf
                      @method('DELETE')
                      <button class="dropdown-item btn text-danger">Delete</button>
                    </form>
                  </div>
                </div>
                <button class="btn btn-dark"
                  onClick="window.location = '{{ route('packs.show', $pack['id'] ) }}'">
                  Open
                </button>
              </div>
            </div>
          </div>
        @endforeach


      </div>
    </div>
  </div>
</div>


{{-- {{-- <button class="btn btn-success update mb-1">Update label</button> --}}
@endsection

@section('scripts')
<script>


</script>
@endsection
