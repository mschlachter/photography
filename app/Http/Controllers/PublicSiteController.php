<?php

namespace App\Http\Controllers;

use App\Album;
use App\Image;
use App\Tag;

class PublicSiteController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $albums = Album::active()
            ->with(['defaultImage', 'defaultImage.media'])
            ->orderByDesc('date')
            ->limit(7)
            ->get();
        return view('welcome', compact('albums'));
    }

    /**
     * Show the albums page.
     *
     * @return \Illuminate\View\View
     */
    public function allAlbums()
    {
        $albums = Album::active()
            ->with(['defaultImage', 'defaultImage.media'])
            ->orderByDesc('date')
            ->paginate(48);
        return view('albums/all', compact('albums'));
    }

    /**
     * Show the album page.
     *
     * @return \Illuminate\View\View
     */
    public function showAlbum(Album $album)
    {
        $album = $album->load(['defaultImage', 'defaultImage.media', 'images', 'images.media']);
        return view('albums/details', compact('album'));
    }

    /**
     * Show the images page.
     *
     * @return \Illuminate\View\View
     */
    public function allImages()
    {
        $searchTags = request('tag');
        $imageQuery = Image::active()
            ->with(['media'])
            ->when($searchTags, function($query) use ($searchTags) {
                return $query->whereHas('tags', function ($query) use ($searchTags) {
                    $query->whereIn('name', $searchTags);
                }, '=', count(array_unique($searchTags)));
            })
            ->orderByDesc('date')
            ->orderByDesc('id');

        $tags = Tag::when($searchTags, function($query) use ($searchTags) {
            $query->whereHas('images', function($query) use ($searchTags) {
                return $query->active()->whereHas('tags', function ($query) use ($searchTags) {
                    $query->whereIn('name', $searchTags);
                }, '=', count(array_unique($searchTags)));
            });
        })->when(!$searchTags, function($query) {
            $query->whereHas('images', function($query) {
                return $query->active();
            });
        })->orderBy('name')->pluck('name')->toArray();

        $images = $imageQuery->paginate(48);
        if ($searchTags) {
            $images->appends(['tags' => $searchTags])
        }

        if (request()->ajax()) {
            return [
                'tags' => $tags,
                'imageView' => view('images/ajaxContent', compact('images', 'searchTags'))->render(),
            ];
        }
        return view('images/all', compact('images', 'tags', 'searchTags'));
    }

    /**
     * Show the album image page.
     *
     * @return \Illuminate\View\View
     */
    public function showAlbumImage(Album $album, Image $image)
    {
        $image->load(['album', 'media', 'tags']);

        $previous = $album->images()->where('id', '<', $image->id)->orderBy('id','desc')->first();
        $next = $album->images()->where('id', '>', $image->id)->orderBy('id')->first();

        return view('albums/image', compact('album', 'image', 'previous', 'next'));
    }

    /**
     * Show the image page.
     *
     * @return \Illuminate\View\View
     */
    public function showImage(Image $image)
    {
        $searchTags = request('searchTags');
        $images = Image::active()
            ->when($searchTags, function($query) use ($searchTags) {
                return $query->whereHas('tags', function ($query) use ($searchTags) {
                    $query->whereIn('name', $searchTags);
                }, '=', count(array_unique($searchTags)));
            })
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->get();
        $previous = null;
        $current = null;
        $next = null;
        foreach ($images as $checkImage) {
            if ($checkImage->id == $image->id) {
                $current = $checkImage;
            } elseif ($current === null) {
                $previous = $checkImage;
            } elseif ($next === null) {
                $next = $checkImage;
                break;
            }
        }
        
        return view('images/show', compact('image', 'previous', 'next', 'searchTags'));
    }

    /**
     * Show the sitemap.
     *
     * @return \Illuminate\View\View
     */
    public function sitemap()
    {
        return response(view('sitemap'))->withHeaders([
            'Content-Type' => 'text/xml',
        ]);
    }

    /**
     * Show the robots.txt file.
     *
     * @return \Illuminate\View\View
     */
    public function robots()
    {
        return response(view('robots'))->withHeaders([
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * Download an image.
     *
     * @return \Illuminate\View\View
     */
    public function download(Image $image)
    {
        if(!config('settings.enable_download_link', false)) {
            abort(404, 'Download Link Disabled');
        }
        return $image->getFirstMedia('image');
    }

    /**
     * Show the RSS feed.
     *
     * @return \Illuminate\View\View
     */
    public function rss()
    {
        $albums = Album::active()->with(['images'])->orderByDesc('date')->limit(25)->get();
        return response(view('rss', compact('albums')))->withHeaders([
            'Content-Type' => 'application/xml',
        ]);
    }
}
