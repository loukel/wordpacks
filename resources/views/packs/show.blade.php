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
      <div class="d-flex justify-content-center md-form form-sm w-100 flex-wrap">
        @csrf
        <input class="form-control mr-2 w-75" type="text" placeholder="Add" aria-label="Add" id="word">
        <button class="btn btn-outline-dark mr-2" onClick="add_word('{{ $pack_id }}', 'defined')">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
            <path fill-rule="evenodd"
              d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
          </svg>
        </button>
        <button class="btn btn-outline-dark add" onClick="add_word('{{ $pack_id }}')">
          Custom Word
        </button>
      </div>
    </div>
  </div>
  @if($words != null)
    @foreach(array_reverse($words) as $word)

      <div class="card mb-3">
        <h5 class="card-header bold">{{ $word['word'] }}</h5>
        <div class="card-body">
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
        </div>
      </div>

    @endforeach
  @endif
</div>

<script>
  function add_word(pack_id) {
    let word = document.getElementById('word').value;
    if (word) {
      var request = new XMLHttpRequest();

      request.open("post", pack_id + "/add/" + word, true);
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
      };
      request.send();
      document.getElementById('word').value = "";
    } else {
      console.log("No word inputted");
    }
  }

  function display_word(word_info) {
    console.log(word_info);
  }

</script>

@endsection
