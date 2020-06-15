<?php

use Illuminate\Support\Facades\Route;
use App\Album;
use App\Image;
use App\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $albums = Album::select()
        ->with(['images'])
        ->orderByDesc('date')
        ->limit(7)
        ->get();
    return view('welcome', compact('albums'));
})->name('home');

Route::get('/albums', function () {
    $albums = Album::select()
        ->with(['images'])
        ->orderByDesc('date')
        ->paginate(50);
    return view('albums/all', compact('albums'));
})->name('albums.all');

Route::get('/albums/{album:slug}', function (Album $album) {
    return view('albums/details', compact('album'));
})->name('albums.show');

Route::get('/photos', function () {
    $tags = request('tag');
    $imageQuery = Image::select()
        ->when($tags, function($query) use ($tags) {
            return $query->whereHas('tags', function ($query) use ($tags) {
                $query->whereIn('name', $tags);
            }, '=', count(array_unique($tags)));
        })
        ->orderByDesc('date');

    $tags = Tag::when($imageQuery->count(), function($query) use ($imageQuery) {
        $query->whereHas('images', function($query) use ($imageQuery) {
            $query->whereIn('images.id', $imageQuery->pluck('id'));
        });
    })->orderBy('name')->pluck('name')->toArray();

    $images = $imageQuery->paginate(50);

    if(request()->ajax()) {
        return [
            'tags' => $tags,
            'imageView' => view('images/ajaxContent', compact('images'))->render(),
        ];
    }
    return view('images/all', compact('images', 'tags'));
})->name('images.all');

Route::get('/albums/{album:slug}/{image:slug}', function (Album $album, Image $image) {
    $images = $album->images;
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
        }
    }
    
    return view('albums/image', compact('album', 'image', 'previous', 'next'));
})->name('albums.image.show');

Route::get('/photos/{image:slug}', function (Image $image) {
    $images = Image::select()
        ->orderByDesc('date')
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
    
    return view('images/show', compact('image', 'previous', 'next'));
})->name('images.show');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('dashboard')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'admin/', 'as' => 'admin.'], function () {
    Route::resources([
        'albums' => 'AlbumController',
        'images' => 'ImageController',
        'tags' => 'TagController',
        'tag-categories' => 'TagCategoryController',
    ]);
    
    // Profile
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

Route::get('sitemap.xml', function() {
    return response(view('sitemap'))->withHeaders([
        'Content-Type' => 'text/xml',
    ]);
});

Route::get('download/{image:slug}', function (Image $image) {
    return $image->getFirstMedia('image');
})->name('download');

Route::get('rss.xml', function () {
    $albums = Album::with(['images'])->orderByDesc('date')->limit(25)->get();
    return response(view('rss', compact('albums')))->withHeaders([
        'Content-Type' => 'application/xml',
    ]);
})->name('rss');
