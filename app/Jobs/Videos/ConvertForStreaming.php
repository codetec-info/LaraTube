<?php

namespace Laratube\Jobs\Videos;

use FFMpeg\Format\Video\X264;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Laratube\Video;
use FFMpeg;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video;

    /**
     * Create a new job instance.
     *
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Set internet quality according to user's internet
        $low = (new X264('aac'))->setKiloBitrate(100);
        $med = (new X264('aac'))->setKiloBitrate(250);
        $high = (new X264('aac'))->setKiloBitrate(500);

        FFMpeg::fromDisk('local')
            ->open($this->video->path)
            ->exportForHLS()
<<<<<<< HEAD
//            ->onProgress(function ($percentage) {
//                $this->video->update([
//                    'percentage' => $percentage
//                ]);
//            })
=======
            ->onProgress(function ($percentage) {
                $this->video->update([
                    'percentage' => $percentage
                ]);
            })
>>>>>>> 6ea1686e2fa06c24a80d377908c8fe996ac65696
            ->addFormat($low)
            ->addFormat($med)
            ->addFormat($high)
            ->save("public/videos/{$this->video->id}/{$this->video->id}.m3u8"); // extension used for streaming files
    }
}
