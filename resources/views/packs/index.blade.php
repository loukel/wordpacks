@extends('layouts.app')

@section('content')

<div class="container">
  @if($logged_in)
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between">
        <div class="h4">My Packs</div>
        <form action="{{ route('packs.create') }}" method="post">
          @csrf
          <button class="btn btn-success" role="button">
            <span>Create</span>
          </button>
        </form>
      </div>
      <div class="card-body">
        @if($packs == '[]')
          <div class="text-center">
            <div class="h5 m-4">No Packs</div>
          </div>
        @endif
        <div class="row">
          @foreach($packs as $pack)
            <div class="col-sm-4 py-2 pack">
              <div class="card card-body h-100">
                <div class="h3 label" id="label_{{ $pack['id'] }}"
                  onkeydown="enter_check('{{ $pack['id'] }}')"
                  onfocusout="update_label('{{ $pack['id'] }}')">
                  {{ $pack['label'] }}
                </div>
                {{-- editing --}}
                <div class="btn-group" id="btns_{{ $pack['id'] }}">
                  <div class="btn-group dropdown edit">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu">
                      <button class="dropdown-item btn"
                        onclick="make_editable('{{ $pack['id'] }}')">Edit</button>
                      <form
                        action="{{ route('packs.destroy', $pack['id']) }}"
                        method="post"
                        onsubmit="if(!confirm('Are you sure you want to delete this pack?')){return false;}">
                        @csrf
                        @method('DELETE')
                        <button class="dropdown-item btn text-danger">Delete</button>
                      </form>
                    </div>
                  </div>
                  <button class="btn btn-dark edit"
                    onClick="window.location = '{{ route('packs.show', $pack['id'] ) }}'">
                    Open
                  </button>
                  <button class="btn btn-success update"
                    onclick="update_label('{{ $pack['id'] }}')">Update</button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @else
    <div class="card mb-3">
      <div class="card-header h4">
        Welcome
      </div>
      <div class="card-body text-center">
        <div class="h5">Word Packs is a web app designed to define and organise unfamilliar words that you
          have encountered. It is a
          great companion to use while reading books. It can also help with academic studies by storing important
          keywords.
        </div>
        <a class="btn btn-primary mt-2 " href="{{ route('register') }}">Register</a>
      </div>
    </div>
  @endif

  <div class="card">
    <div class="card-header h4">
      Public Packs - <span class="text-muted">Recently Created</span>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($public_packs as $pack)
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


{{-- {{-- <button class="btn btn-success update mb-1">Update label</button> --}}
@endsection

@section('scripts')
<script>
  function enter_check(pack_id) {
    if (event.key === 'Enter') {
      update_label(pack_id)
    }
  }

  function make_editable(pack_id) {
    var label = document.getElementById('label_' + pack_id);
    label.contentEditable = true;
    label.focus();
    document.getElementById('btns_' + pack_id).classList.toggle('editing');
  }

  function update_label(pack_id) {
    var label = document.getElementById('label_' + pack_id);
    label.contentEditable = false;

    params = "label=" + label.innerHTML;
    request = new async_request();

    request.open("post", `/${pack_id}/update`, true);
    // Set csrf token up
    request.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector("[name~=csrf-token][content]").content)

    request.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
    request.setRequestHeader('Content-type', params.length);
    request.setRequestHeader('Connection', "close");

    request.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(this.responseText)
      }
    }
    request.send(params);

    buttons = document.getElementById('btns_' + pack_id);
    buttons.classList.toggle('editing');
    buttons.focus();
  }

  function async_request() {
    try {
      var request = new XMLHttpRequest()
    } catch (e1) {
      try {
        request = new ActiveXObject("Msxml2.XMLHTTP")
      } catch (e2) {
        try {
          request = new ActiveXObject("Microsoft.XMLHTTP")
        } catch (e3) {
          request = false
        }
      }
    }
    return request
  }

</script>
@endsection
