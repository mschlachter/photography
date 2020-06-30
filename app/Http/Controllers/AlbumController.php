<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::select()
            ->orderByDesc('date')
            ->withCount('images')
            ->paginate(20);
        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.albums.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|before:tomorrow'
        ]);
        $album = Album::create($validated);
        return redirect(route('admin.albums.edit', compact('album')))->withStatus(__('Album successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        return redirect(route('admin.albums.edit', compact('album')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view('admin.albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date|before:tomorrow'
        ]);
        $album->update($validated);
        return back()->withStatus(__('Album information successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect(route('admin.albums.index'));
    }

    public function updateIsActive(Request $request, Album $album)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean'
        ]);
        $album->update($validated);
        if ($request->ajax()) {
            return [
                'result' => true,
            ];
        }
        return back()->withStatus(__('Album publish status successfully updated.'));
    }
}
