<?php

namespace backend\filters;

use backend\models\Apple;

class AppleFilter
{
    public static function appleToFrontEndModel(Apple $apple)
    {
        $volume = $apple->current_volume * 100;
        return [
            'id' => $apple->id,
            'color' => $apple->color->sys_name,
            'fallenDate' => $apple->fallen_date,
            'statusName' => $apple->status->name,
            'currentVolume' => $volume . '%'
        ];
    }
}
