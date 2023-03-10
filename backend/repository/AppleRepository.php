<?php

namespace backend\repository;

use backend\dataProvider\StatusDataProvider;
use backend\models\Apple;
use backend\workflow\StatusEnums;
use backend\models\Color;
use Yii;

class AppleRepository
{
    public static function createNew(Color $color): Apple
    {
        $statusOnTree = StatusDataProvider::getStatus(StatusEnums::STATE_ON_TREE);

        $apple = new Apple;
        $apple->color_id = $color->id;
        $apple->status_id = $statusOnTree->id;
        $apple->save();

        return $apple;
    }

    public static function clearAll()
    {
        Yii::$app->db->createCommand()->truncateTable(Apple::tableName())->execute();
    }

    public static function findById(int $appleId): ?Apple
    {
        return Apple::findOne($appleId);
    }

    public static function deleteApple(int $appleId)
    {
        $apple = Apple::findOne($appleId);

        if ($apple) {
            $apple->delete();
        }
    }
}
