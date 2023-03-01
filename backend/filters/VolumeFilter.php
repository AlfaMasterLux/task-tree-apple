<?php

namespace backend\filters;

class VolumeFilter
{
    public static function VolumeToBackModel($volume)
    {
        return $volume > 0 ? $volume/100 : $volume;
    }
}