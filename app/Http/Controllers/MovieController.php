<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Intervention\Image\ImageManagerStatic as Image;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     */
    public function index(): View
    {
        $pendingMovies = auth()->user()->movies()->where('watched', false)->get();
        $watchedMovies = auth()->user()->movies()->where('watched', true)->get();
        return view('movies.index', compact('pendingMovies', 'watchedMovies'));
    }

    /**
     * Show the form for creating a new movie.
     */
    public function create(): View
    {
        return view('movies.create');
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u|max:30',
            'release_year' => 'nullable|integer',
            'synopsis' => 'nullable',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $movie = $request->user()->movies()->create($validated);
    
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'covers/' . $fileName;
    
            // Validar el tipo de archivo
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            $extension = strtolower($image->getClientOriginalExtension());
    
            if (in_array($extension, $allowedExtensions)) {
                // Redimensionar la imagen
                list($width, $height) = getimagesize($image->getRealPath());
                $newWidth = 300; // Ancho deseado
                $newHeight = 300; // Alto deseado
    
                $thumb = \imagecreatetruecolor($newWidth, $newHeight);
                $source = \imagecreatefromstring(file_get_contents($image->getRealPath()));
    
                if ($source !== false) {
                    \imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    
                    // Guardar la imagen redimensionada
                    $storagePath = storage_path('app/public/' . $filePath);
                    \imagejpeg($thumb, $storagePath);
    
                    $movie->cover_image = $filePath;
                    $movie->save();
                } else {
                    // Manejo de error si no se pudo leer la imagen
                    return redirect()->back()->withErrors(['cover_image' => 'El archivo de imagen no es válido.']);
                }
            } else {
                // Manejo de error si la extensión no está permitida
                return redirect()->back()->withErrors(['cover_image' => 'El tipo de archivo no está permitido.']);
            }
        }
    
        return redirect()->route('movies.index')->with('success', 'La película se ha creado correctamente.');
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit(Movie $movie): View
    {
        // Verifica que el usuario autenticado es el propietario de la película
        if (auth()->user()->id !== $movie->user_id) {
            abort(403, 'No tienes permiso para editar esta película.');
        }

        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie): RedirectResponse
    {
        if (auth()->user()->id !== $movie->user_id) {
            abort(403, 'No tienes permiso para actualizar esta película.');
        }

        $validated = $request->validate([
            'name' => 'required',
            'release_year' => 'required|integer',
            'synopsis' => 'required',
            'cover_image' => 'image|nullable'
        ]);

        $movie->update($validated);

        if ($request->hasFile('cover_image')) {
            $movie->cover_image = $request->file('cover_image')->store('covers', 'public');
            $movie->save();
        }

        return redirect()->route('movies.index')->with('success', 'La película se ha actualizado correctamente.');
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie): RedirectResponse
    {
        if (auth()->user()->id !== $movie->user_id) {
            abort(403, 'No tienes permiso para eliminar esta película.');
        }

        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'La película se ha eliminado correctamente.');
    }
}

