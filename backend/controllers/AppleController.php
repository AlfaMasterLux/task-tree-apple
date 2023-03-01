<?php

namespace backend\controllers;

use backend\models\TreeManager;
use backend\filters\VolumeFilter;
use backend\service\AppleService;
use backend\service\AppleTreeService;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AppleController extends Controller
{
    /**
     * @var AppleTreeService
     */
    protected $appleTreeService;

    /**
     * @var AppleService
     */
    protected $appleService;

    /**
     * @var TreeManager
     */
    protected $treeManager;

    public function __construct($id, $module, AppleTreeService $appleTreeService,
                                AppleService $appleService,
                                TreeManager $treeManager)
    {
        parent::__construct($id, $module);
        $this->appleTreeService = $appleTreeService;
        $this->appleService = $appleService;
        $this->treeManager = $treeManager;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','create-new-tree','apple-fall','apple-eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create-new-tree' => ['post'],
                    'apple-fall' => ['post'],
                    'apple-eat' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->renderWithTree();
    }

    public function actionCreateNewTree()
    {
        $this->appleTreeService->createNewTree();

        return $this->renderWithTree();
    }

    /**
     * @return string
     */
    public function actionAppleFall()
    {
        $appleId = Yii::$app->request->post('appleId');

        $error = null;

        try {
            $this->appleService->fallApple($appleId);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }

        return $this->renderWithTree($appleId, $error);
    }

    public function actionAppleEat()
    {
        $appleId = Yii::$app->request->post('appleId');
        $volume = Yii::$app->request->post('volume');
        $volume = VolumeFilter::VolumeToBackModel($volume);

        $error = null;

        try {
            $this->appleService->eatApple($appleId, $volume);
        } catch (Throwable $e){
            $error = $e->getMessage();
        }

        return $this->renderWithTree($appleId, $error);
    }

    protected function renderWithTree($appleId = null, $error = null)
    {
        $treeFrontData = $this->treeManager->treeToFrontModel($appleId, $error);

        return $this->render('index', [
            'apples' => $treeFrontData['apples'],
            'colors' => $treeFrontData['colors'],
            'appleId' => null
        ]);
    }
}
