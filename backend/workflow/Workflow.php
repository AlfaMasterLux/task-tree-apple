<?php

namespace backend\workflow;

use backend\models\Apple;
use backend\workflow\appleAction\AppleEatAction;
use backend\workflow\appleAction\AppleFallAction;

class Workflow
{
    public function appleFall(Apple $apple): Apple
    {
        $action = new AppleFallAction($apple);

        return $action->execute();
    }

    public function appleEat(Apple $apple, $volume): ?Apple
    {
        $action = new AppleEatAction($apple, ['volume' => $volume]);

        $action->execute();

        return $action->getApple();
    }
}
