@extends('layouts.base')

@section('title','edit post')

@section('content')
    <h1>Edita post: {{$post->title}}</h1>  
    
    <form action="{{route("admin.posts.update", $post->id)}}" method="POST">
        
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Inserisci il titolo del post" value="{{old('title', $post->title)}}">
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Inserisci il contenuto del post">{{old('content', $post->content)}}</textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Tags</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input type="checkbox" name="tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->slug}}"

                    @if($errors->any())
                        {{ in_array($tag->id, old('tags', []) ) ? " checked" : ""}}
                    @else
                        {{$post->tags->contains($tag) ? "checked" : ""}}
                    @endif

                    >
                    <label for="{{$tag->slug}}" class="form-check-label">
                        {{$tag->name}}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="category_id">Categoria</label>
            <select name="category_id">
                <option value="">-----</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ $category->id == old('category_id', $post->category_id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <a href="{{route("admin.posts.index")}}"><button type="button" class="btn btn-primary">back</button></a>
        <button type="submit" class="btn btn-success">save</button>
    </form>
    <form id="ms_delete-btn" action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo post?');">delete</button>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
@endsection