<?php

namespace App\Http\Controllers;

use App\Image;
use App\Tag;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('admin.albums.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect(route('admin.albums.index'));
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
            'album_id' => 'required|exists:albums,id',
            'title-new' => 'required|string|max:255',
            'alt-new' => 'required|string|max:255',
            'date-new' => 'required|date|before:tomorrow',
            'file-new' => 'required|image',
        ]);
        $image = Image::create([
            'album_id' => $validated['album_id'],
            'title' => $validated['title-new'],
            'alt' => $validated['alt-new'],
            'date' => $validated['date-new'],
        ]);
        if ($image->album->default_image_id == null) {
            $image->album->update(['default_image_id' => $image->id]);
        }
        // Update the slug (with the new ID)
        $image->save();
        $tagIds = [];
        foreach(explode(', ', $validated['tags-' . $image->id] ?? '') as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $image->tags()->sync($tagIds);
        $image->addMedia($validated['file-new'])->withResponsiveImages()->toMediaCollection('image');
        return back()->with(['imageStatus' => __('Image successfully added.')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return redirect(route('admin.albums.edit', ['album' => $image->album]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return redirect(route('admin.albums.edit', ['album' => $image->album]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        $validated = $request->validate([
            'title-' . $image->id => 'required|string|max:255',
            'alt-' . $image->id => 'required|string|max:255',
            'date-' . $image->id => 'required|date|before:tomorrow',
            'tags-' . $image->id => 'nullable|string',
        ]);
        $image->update([
            'title' => $validated['title-' . $image->id],
            'alt' => $validated['alt-' . $image->id],
            'date' => $validated['date-' . $image->id],
        ]);
        $tagIds = [];
        foreach(explode(', ', $validated['tags-' . $image->id] ?? '') as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }
        $image->tags()->sync($tagIds);
        return back()->with(['imageStatus' => __('Image successfully updated.')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->delete();
        return back()->with(['imageStatus' => __('Image successfully deleted.')]);
    }
}
