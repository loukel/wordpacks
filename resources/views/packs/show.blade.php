@extends('layouts.app')

@section('content')

<div class="container" id="container">
  <div class="h1 text-center" {{ $is_creator ? 'contentEditable=true' : null }}
    onfocusout="update_label('{{ $pack_id }}')" onkeydown="enter_check('{{ $pack_id }}')" id="label">
    {{ $label }}
  </div>
  {{-- <small class="text-muted">Created by: {{ $creator }}</small> --}}
  @if($is_creator)
    <div class="card mb-3">
      <div class="card-body">
        <form class="d-flex justify-content-center md-form form-sm w-100 flex-wrap" method="post"
          action="{{ route('packs.add') }}">
          @csrf
          <input type="hidden" name="pack_id" value="{{ $pack_id }}">
          <input class="form-control mr-2 w-75" type="text" placeholder="Add" aria-label="Add" name="word">
          <button class="btn btn-outline-dark mr-2" name="define">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
              <path fill-rule="evenodd"
                d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
            </svg>
          </button>
          <button class="btn btn-outline-dark add" name="custom">
            Custom Word
          </button>
        </form>
      </div>
    </div>
  @endif
  <p>{{ session('error') }}</p>
  @if($words != null)
    @foreach(array_reverse($words) as $word)
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5>{{ $word['word'] }}</h5>
          @if($is_creator)
            <div class="btn-toolbar" id="btns_{{ $word['word'] }}" role="group">

              @if(empty($word['senses']))
                <button class="btn btn-sm btn-primary float-right edit"
                  onclick="make_editable('{{ $word['word'] }}')">
                  Edit
                </button>
                <button class="btn btn-sm btn-success float-right update"
                  onclick="update_note('{{ $pack_id }}','{{ $word['word'] }}')">
                  Update
                </button>
              @endif
              <form
                action="{{ route('packs.delete', ['pack_id' =>$pack_id,'word'=>$word['word']]) }}"
                method="post">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger float-right ml-1">Delete</button>
              </form>
            </div>
          @endif
        </div>
        <div class="card-body">
          @if(!empty($word['senses']))
            @foreach($word['senses'] as $sense)
              <div class="sense mb-3">
                <h5 class="card-subtitle font-italic">{{ $sense['pos'] }}</h5>
                @foreach($sense['definitions'] as $definition)
                  <p class="card-text">{{ $definition }}</p>
                  @if($loop->index >= 2)
                    @break
                  @endif
                @endforeach
              </div>
            @endforeach
          @else
            <form id='form_{{ $word['word'] }}'>
              <p class="note" data-placeholder="Note" onfocus="this.value = this.value;">{{ $word['notes'] }}</p>
            </form>
          @endif
        </div>
      </div>

    @endforeach
  @else
    <script>
      var label = document.getElementById('label');
      label.focus();

    </script>
  @endif
</div>

@endsection

@section('scripts')
<script>
  function enter_check(pack_id) {
    if (event.key === 'Enter') {
      update_label(pack_id)
    }
  }

  function update_label(pack_id) {
    var label = document.getElementById('label');
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
    label.blur();
  }

  function make_editable(word) {
    var note = document.getElementById('form_' + word).getElementsByTagName('p')[0];
    note.contentEditable = true;
    note.focus();
    document.getElementById('btns_' + word).classList.toggle('editing');
  }

  function update_note(pack_id, word) {
    var note = document.getElementById('form_' + word).getElementsByTagName('p')[0];
    note.contentEditable = false;

    params = "note=" + note.innerHTML;
    request = new async_request();

    request.open("post", `${pack_id}/edit/${word}`, true);
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

    buttons = document.getElementById('btns_' + word);
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
