<?php

namespace backend\workflow\treeAction;

use backend\dataProvider\StatusDataProvider;
use backend\models\Apple;
use backend\workflow\StatusEnums;

class MarkAppleRottenAction
{
    public function execute()
    {
        $dateRotten = StatusEnums::getTimeForRotten();

        $statusOnGround = StatusDataProvider::getStatus(StatusEnums::STATE_ON_GROUND);
        $statusRotten = StatusDataProvider::getStatus(StatusEnums::STATE_ROTTEN);

        return Apple::updateAll([
            'status_id' => $statusRotten->id
        ], ['AND',
            ['=','status_id', $statusOnGround->id],
            ['<','fallen_date', $dateRotten->format('Y-m-d H:i:s')]
        ]);
    }
}
