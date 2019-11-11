<?php

namespace Laratube\Http\Controllers;

use Laratube\Video;

class VideoController extends Controller
{
    public function show(Video $video)
    {
        // if it is called from ajax request
        if (request()->wantsJson()) {
            return $video;
        }
        return view('video', compact('video'));
    }

    public function updateViews(Video $video)
    {
        $video->increment('views');

        return response()->json([]);
    }
}
