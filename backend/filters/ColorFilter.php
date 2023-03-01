<?php

namespace backend\filters;

use backend\models\Color;

class ColorFilter
{
    public static function selectColorSysName(Color $color)
    {
        return $color->sys_name;
    }
}
