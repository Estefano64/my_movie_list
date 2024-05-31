
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Movie</h1>
    <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="release_year">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" required>
        </div>
        <div class="form-group">
            <label for="synopsis">Synopsis</label>
            <textarea class="form-control" id="synopsis" name="synopsis" required></textarea>
        </div>
        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="watched" name="watched">
            <label class="form-check-label" for="watched">Watched</label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
