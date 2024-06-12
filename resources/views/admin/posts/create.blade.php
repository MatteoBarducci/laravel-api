@extends('layouts.admin')

@section('content')
    <h2>Crea un nuovo post</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Immagine</label>
            <input class="form-control" type="file" id="cover_image" name="cover_image">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option @selected($category->id == old('category_id')) value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        <div>

        <div class="mb-3 mt-4">
            <h5>Tags</h5>

            @foreach ($tags as $tag)
                <div class="form-check">
                    <input @checked(in_array($tag->id, old('tags', []))) class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag-{{ $tag->id }}">
                    <label class="form-check-label" for="tag-{{ $tag->id }}">
                    {{ $tag->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mb-3 mt-4">
            <label for="content" class="form-label">Contenuto</label>
            <textarea class="form-control" id="content" rows="15" name="content">{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Salva</button>
    </form>
@endsection
