@extends('layouts.app')

@section('content')
<div class="container">
  <div class="h2 text-center mb-3">Community</div>

  <div class="card mb-3">
    <div class="card-header h4">
      Books
    </div>
    <div class="card-body">
      <div class="row">

      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header h4">
      Recently created packs
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($packs as $pack)
          <div class="col-sm-4 py-2 pack">
            <div class="card card-body h-100">
              <div class="h3 label" id="label_{{ $pack['id'] }}"
                onkeydown="enter_check('{{ $pack['id'] }}')">
                {{ $pack['label'] }}
              </div>
              <div class="text-muted text-cente">
                Created by {{ $pack['username'] }}
              </div>
              {{-- editing --}}
              <div class="btn-group" id="btns_{{ $pack['id'] }}">
                <button class="btn btn-dark edit"
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
@endsection
