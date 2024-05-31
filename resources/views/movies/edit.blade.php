<!-- resources/views/movies/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Movie</h1>
    <form action="{{ route('movies.update', $movie) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $movie->name }}" required>
        </div>
        <div class="form-group">
            <label for="release_year">Release Year</label>
            <input type="number" class="form-control" id="release_year" name="release_year" value="{{ $movie->release_year }}" required>
        </div>
        <div class="form-group">
            <label for="synopsis">Synopsis</label>
            <textarea class="form-control" id="synopsis" name="synopsis" required>{{ $movie->synopsis }}</textarea>
        </div>
        <div class="form-group">
            <label for="cover_image">Cover Image</label>
            <input type="file" class="form-control" id="cover_image" name="cover_image">
            @if ($movie->cover_image)
                   <img src="{{ asset('storage/' . $movie->cover_image) }}" alt="Cover Image" style="max-width: 200px; margin-top: 20px;">
               @endif
           </div>
           <div class="form-check">
               <input type="checkbox" class="form-check-input" id="watched" name="watched" {{ $movie->watched ? 'checked' : '' }}>
               <label class="form-check-label" for="watched">Watched</label>
           </div>
           <button type="submit" class="btn btn-primary">Update</button>
       </form>
   </div>
   @endsection

