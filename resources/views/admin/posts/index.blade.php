@extends('layouts.admin')

@section('content')
    @include('partials.flash-messages')

    <h1>Tutti i post</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->created_at }}</td>

                    <td>
                        <div>
                            <a href="{{ route('admin.posts.show', ['post' => $post->slug]) }}">View</a>
                        </div>

                        <div>
                            <a href="{{ route('admin.posts.edit', ['post' => $post->slug]) }}">Edit</a>
                        </div>

                        <div>
                            <form action="{{ route('admin.posts.destroy', ['post' => $post->slug]) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection