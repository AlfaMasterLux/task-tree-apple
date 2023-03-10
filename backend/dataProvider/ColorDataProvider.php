<?php

namespace backend\dataProvider;

use backend\models\Color;

class ColorDataProvider
{
    public static function getRandomColor(): Color
    {
        return Color::find()
            ->select('*')
            ->orderBy(new \yii\db\Expression('rand()'))
            ->limit(1)
            ->one();
    }

    public static function getAllColors(): array
    {
        return Color::find()
            ->select('*')
            ->all();
    }
}
