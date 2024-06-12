@extends('layouts.admin')

@section('content')
    @include('partials.flash-messages')

    <h2>{{ $post->title }}</h2>

    <div>
        <strong>ID</strong>: {{ $post->id }}
    </div>

    <div>
        <strong>Slug</strong>: {{ $post->slug }}
    </div>

    <div>
        <strong>Category</strong>: {{ $post->category ? $post->category->name : 'No category' }}
    </div>

    <div>
        <strong>Tags</strong>:
        @if (count($post->tags) > 0)
            @foreach ($post->tags as $tag)
                {{ $tag->name }}@if (!$loop->last),@endif
            @endforeach
        @else
            none
        @endif
    </div>

    <div>
        <strong>Created at</strong>: {{ $post->created_at }}
    </div>

    <div>
        <strong>Updated at</strong>: {{ $post->updated_at }}
    </div>

    @if ($post->cover_image)
        <div>
            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
        </div>
    @endif

    @if ($post->content)
        <p class="mt-5">{{ $post->content }}</p>
    @endif
@endsection
