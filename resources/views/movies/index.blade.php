<!-- resources/views/movies/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Movie List</h1>
    <a href="{{ route('movies.create') }}" class="btn btn-primary">Add Movie</a>

    <h2>Pending Movies</h2>
    <ul>
        @foreach ($pendingMovies as $movie)
            <li>
                <a href="{{ route('movies.edit', $movie) }}">{{ $movie->name }} ({{ $movie->release_year }})</a>
                <form action="{{ route('movies.destroy', $movie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h2>Watched Movies</h2>
    <ul>
        @foreach ($watchedMovies as $movie)
            <li>
                {{ $movie->name }} ({{ $movie->release_year }})
                <form action="{{ route('movies.destroy', $movie) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
