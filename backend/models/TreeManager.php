<?php

namespace backend\models;

use backend\dataProvider\ColorDataProvider;
use backend\filters\ColorFilter;
use backend\filters\TreeFilter;
use backend\service\AppleTreeService;

/**
 * Class TreeManager
 * @package backend\models
 */
class TreeManager
{
    protected $appleTreeService;

    public function __construct(AppleTreeService $appleTreeService)
    {
        $this->appleTreeService = $appleTreeService;
    }

    public function treeToFrontModel($appleId=null, $error=null): array
    {
        $colors = $this->getColorsToFrontModel();
        $apples = TreeFilter::treeToFrontModel($this->appleTreeService->getAllApples());

        $apples = $this->appleWithErrors($apples, $appleId, $error);

        return [
            'colors' => $colors,
            'apples' => $apples
        ];

    }

    protected function getColorsToFrontModel(): array
    {
        $colors = [];
        $colorObjects = ColorDataProvider::getAllColors();
        foreach ($colorObjects as $colorObject) {
            $colors[] = ColorFilter::selectColorSysName($colorObject);
        }

        return $colors;
    }

    public function appleWithErrors(array $apples, int $appleId = null, $error = null): array
    {
        foreach ($apples as $key => $item) {
            $apples[$key]['errors'] = $item['id'] == $appleId ? $error : null;
        }

        return $apples;
    }
}
