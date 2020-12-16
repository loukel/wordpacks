@extends('layouts.app')

@section('content')
<div class="container">
  <p>Word packs is a web app </p>
  {{-- <div class="card mb-3">
    <div class="card-header h4">
      Books
    </div>
    <div class="card-body">
      <div class="row justify-content-center">
        <img src="https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1333576876l/10127019.jpg"
          alt="The Lean Startup" width="250px">
      </div>
    </div>
  </div> --}}

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
                <div class="text-muted small text-center">
                  Created by {{ $pack['username'] }}
                </div>
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
