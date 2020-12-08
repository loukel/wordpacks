@extends('layouts.app')

@section('content')

<div class="container" id="container">
  <div class="h1 text-center">
    {{ $label }}
    <br>
    <small class="text-muted">Created by: {{ $creator }}</small>
  </div>
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
  <p>{{ session('error') }}</p>
  @if($words != null)
    @foreach(array_reverse($words) as $word)

      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5>{{ $word['word'] }}</h5>
          <div class="btn-toolbar" role="group">
            @if(empty($word['senses']))
              <button class="btn btn-sm btn-primary float-right">Edit</button>
            @endif
            <form
              action="{{ route('packs.delete', ['pack_id' =>$pack_id,'word'=>$word['word']]) }}"
              method="post">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger float-right ml-1">Delete</button>
            </form>
          </div>
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
            <p>{{ $word['notes'] }}</p>
          @endif
        </div>
      </div>

    @endforeach
  @endif
</div>

<script>
  /*
  function add_word(pack_id, mode) {
    let word = document.getElementById('word').value;
    if (word) {
      var request = new XMLHttpRequest();

      request.open("post", `${pack_id}/add/${word}/${mode}`, true);
      // Set csrf token up
      request.setRequestHeader('X-CSRF-TOKEN', document.head.querySelector("[name~=csrf-token][content]").content)

      request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (this.responseText == -1) {
            //alert('word not exist');
            display_word(this.responseText);
          } else {
            display_word(this.responseText);
          }
        }
      }
      request.send();
      document.getElementById('word').value = "";
    } else {
      console.log("No word inputted");
    }
  }

  function display_word(word_info) {
    console.log(word_info);
  }
  *\

</script>

@endsection
