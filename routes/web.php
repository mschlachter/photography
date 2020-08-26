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

Route::get('/', PublicSiteController::class . '@home')->name('home');

Route::get('/albums', PublicSiteController::class . '@allAlbums')->name('albums.all');

Route::get('/albums/{album:slug}', PublicSiteController::class . '@showAlbum')->name('albums.show');

Route::get('/photos', PublicSiteController::class . '@allImages')->name('images.all');

Route::get('/albums/{album:slug}/{image:slug}', PublicSiteController::class . '@showAlbumImage')->name('albums.image.show');

Route::get('/photos/{image:slug}', PublicSiteController::class . '@showImage')->name('images.show');

Auth::routes(['register' => false]);

Route::redirect('/home', '/admin/dashboard', 301)->name('dashboard')->middleware('auth');

Route::group(['middleware' => 'auth', 'prefix' => 'admin/', 'as' => 'admin.'], function () {
    Route::redirect('/', '/admin/dashboard', 301);

    Route::get('dashboard', 'HomeController@index')->name('dashboard')->middleware('auth');

    Route::resources([
        'albums' => AlbumController::class,
        'images' => ImageController::class,
        'tags' => TagController::class,
        'tag-categories' => TagCategoryController::class,
        'settings' => SettingController::class,
    ]);

    Route::post('albums/{album}/updateIsActive', AlbumController::class . '@updateIsActive')->name('albums.updateIsActive');

    Route::post('settings/update-ga', SettingController::class . '@updateGoogleAnalyticsCredentials')->name('settings.update-ga');
    
    // Profile
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    // Search Results
    Route::get('search', DashboardController::class . '@search')->name('search');

    // Data for dashboard widgets
    Route::group(['prefix' => 'dashboard/data/', 'as' => 'dashboard.data.'], function() {
        Route::get('daily-views', DashboardController::class . '@widgetDailyViews')->name('daily-views');

        Route::get('daily-visitors', DashboardController::class . '@widgetDailyVisitors')->name('daily-visitors');

        Route::get('most-popular-images', DashboardController::class . '@widgetMostPopularImages')->name('most-popular-images');

        Route::get('session-sources', DashboardController::class . '@widgetSessionSources')->name('session-sources');

        Route::get('visitor-count', DashboardController::class . '@widgetVisitorCount')->name('visitor-count');

        Route::get('avg-page-load-speed', DashboardController::class . '@widgetPageLoadTime')->name('avg-page-load-speed');
    });
});

Route::get('sitemap.xml', PublicSiteController::class . '@sitemap')->name('sitemap');

Route::get('robots.txt', PublicSiteController::class . '@robots')->name('robots');

Route::get('download/{image:slug}', PublicSiteController::class . '@download')->name('download');

Route::get('rss.xml', PublicSiteController::class . '@rss')->name('rss');
