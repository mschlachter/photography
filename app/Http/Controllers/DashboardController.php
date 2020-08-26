<?php

namespace App\Http\Controllers;

use App\Album;
use App\Image;
use App\Tag;
use App\Libraries\ToolboxGoogleAnalytics;

class DashboardController extends Controller
{
    /**
     * Show the search page.
     *
     * @return \Illuminate\View\View
     */
    public function search()
    {
        $query = request('q', '');

        $tagResults = Tag::where('name', 'like', "%$query%")->withCount('images');

        $albumResults = Album::where('title', 'like', "%$query%")->withCount('images');

        $imageResults = Image::where('title', 'like', "%$query%")->orWhere('alt', 'like', "%$query%");

        $searchResults = [
            'query' => $query,
            'tags' => $tagResults->get()->map(function($tag) {
                return [
                    'name' => $tag->name,
                    'date' => $tag->created_at->toDateString(),
                    'images' => $tag->images_count,
                    'url' => route('admin.tags.edit', compact('tag')),
                ];
            }),
            'albums' => $albumResults->get()->map(function($album) {
                return [
                    'title' => $album->title,
                    'date' => $album->date,
                    'images' => $album->images_count,
                    'url' => route('admin.albums.edit', compact('album')),
                ];
            }),
            'images' => $imageResults->get()->map(function($image) {
                return [
                    'title' => $image->title,
                    'thumb' => getMediaUrlForSize($image, 100, 100),
                    'date' => $image->date,
                    'album' => [
                        'title' => $image->album->title,
                        'url' => route('admin.albums.edit', ['album' => $image->album]),
                    ],
                    'url' => route('admin.images.edit', compact('image')),
                ];
            }),
        ];

        if(request()->ajax()) {
            return $searchResults;
        }

        return view('admin.search', $searchResults);
    }

    /**
     * Get data for the daily views widget.
     *
     * @return array
     */
    public function widgetDailyViews(ToolboxGoogleAnalytics $analytics)
    {
        $viewsByDay = $analytics->getViewsPerDayForLast7Days();
        $viewsByDayLabels = array_map(function($day) {return substr($day['dayOfWeek'], 0, 1);}, $viewsByDay);
        $viewsByDayValues = array_map(function($day) {return $day['views'];}, $viewsByDay);
        $viewsByDayChange = count($viewsByDayValues) > 2 && $viewsByDayValues[count($viewsByDayValues) - 3] > 0 ? floor(($viewsByDayValues[count($viewsByDayValues) - 2] * 1.0 / $viewsByDayValues[count($viewsByDayValues) - 3] - 1) * 100) : (count($viewsByDayValues) > 0 && $viewsByDayValues[count($viewsByDayValues) - 2] > 0 ? 'Infinity' : 0);

        return [
            'labels' => $viewsByDayLabels,
            'values' => $viewsByDayValues,
            'change' => $viewsByDayChange,
            'update-time' => now()->toTimeString(),
        ];
    }

    /**
     * Get data for the daily visitors widget.
     *
     * @return array
     */
    public function widgetDailyVisitors(ToolboxGoogleAnalytics $analytics)
    {
        $sessionsByDay = $analytics->getUsersPerDayForLast7Days();
        $sessionsByDayLabels = array_map(function($day) {return substr($day['dayOfWeek'], 0, 1);}, $sessionsByDay);
        $sessionsByDayValues = array_map(function($day) {return $day['sessions'];}, $sessionsByDay);
        $sessionsByDayChange = count($sessionsByDayValues) > 2 && $sessionsByDayValues[count($sessionsByDayValues) - 3] > 0 ? floor(($sessionsByDayValues[count($sessionsByDayValues) - 2] * 1.0 / $sessionsByDayValues[count($sessionsByDayValues) - 3] - 1) * 100) : (count($sessionsByDayValues) > 0 && $sessionsByDayValues[count($sessionsByDayValues) - 2] > 0 ? 'Infinity' : 0);

        return [
            'labels' => $sessionsByDayLabels,
            'values' => $sessionsByDayValues,
            'change' => $sessionsByDayChange,
            'update-time' => now()->toTimeString(),
        ];
    }

    /**
     * Get data for the most popular images widget.
     *
     * @return array
     */
    public function widgetMostPopularImages(ToolboxGoogleAnalytics $analytics)
    {
        return $analytics->getMostPopularPages();
    }

    /**
     * Get data for the session sources widget.
     *
     * @return array
     */
    public function widgetSessionSources(ToolboxGoogleAnalytics $analytics)
    {
        return $analytics->getSessionSources();
    }

    /**
     * Get data for the visitor count widget.
     *
     * @return array
     */
    public function widgetVisitorCount(ToolboxGoogleAnalytics $analytics)
    {
        return $analytics->getUsersForLast7Days();
    }

    /**
     * Get data for the page load time widget.
     *
     * @return array
     */
    public function widgetPageLoadTime(ToolboxGoogleAnalytics $analytics)
    {
        return $analytics->getAvgPageLoadSpeedForLast30Days() . ' <small>s<span class="sr-only">econds</span></small>';
    }
}