<?php

namespace App\Base;


use Illuminate\Support\Str;

trait TimeLapse
{

    public function getTimeLapseAttribute()
    {
        $timeCreated = $this->created_at;
        $currentTime = now();

        $timeDiff = $currentTime->diff($timeCreated);
        $suffix = (isset($this->lapse_ago) && $this->lapse_ago)? ' ago':'';
        if ($timeDiff->y > 0) {
            return $timeDiff->format('%y '. Str::plural('year', $timeDiff->y) . ($suffix));
        } elseif ($timeDiff->m > 0) {
            return $timeDiff->format('%m '. Str::plural('month', $timeDiff->m) . ($suffix));
        } elseif ($timeDiff->d > 0) {
            return $timeDiff->format('%d '. Str::plural('day', $timeDiff->d) . ($suffix));
        } elseif ($timeDiff->h > 0) {
            return $timeDiff->format('%h '. Str::plural('hour', $timeDiff->h) . ($suffix));
        } elseif ($timeDiff->i > 0) {
            return $timeDiff->format('%i '. Str::plural('min', $timeDiff->m) . ($suffix));
        } else {
            return 'just now';
        }
    }
}
