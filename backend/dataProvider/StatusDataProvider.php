<?php

namespace backend\dataProvider;

use backend\models\Status;

class StatusDataProvider
{
    public static function getStatus(string $statusSysName): Status
    {
        return Status::find()->where('sys_name=:sys_name', ['sys_name' => $statusSysName])->one();
    }
}