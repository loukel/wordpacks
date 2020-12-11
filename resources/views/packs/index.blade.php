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
              <div class="h3 label" id="label_{{ $pack['id'] }}"
                onkeydown="enter_check('{{ $pack['id'] }}')">
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
