@extends('layouts.base')

@section('title','new post')

@section('content')
    <h1>Crea post</h1>  

    <form action="{{route("admin.posts.store")}}" method="POST">
        
        @csrf

        <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Inserisci il titolo del post" value="{{old('title')}}">
            @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Inserisci il contenuto del post">{{old('content')}}</textarea>
            @error('content')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Tags</label>
            @foreach($tags as $tag)
                <div class="form-check">
                    <input type="checkbox" name="tags[]" class="form-check-input" value="{{$tag->id}}" id="{{$tag->slug}}"
                    {{ in_array($tag->id, old('tags', []) ) ? " checked" : ""}}
                    >
                    <label for="{{$tag->slug}}" class="form-check-label">
                        {{$tag->name}}
                    </label>
                </div>
            @endforeach
            @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Categoria</label>
            <select name="category_id">
                <option value="">-----</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <a href="{{route("admin.posts.index")}}"><button type="button" class="btn btn-primary">back</button></a>
        <button type="submit" class="btn btn-success">add</button>
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