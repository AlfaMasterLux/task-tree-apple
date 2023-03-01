<?php

use yii\helpers\Html;

/**
 * @var $colors array
 * @var $apples array
 * @var $appleId ?int
 */

?> <style> <?php
if (isset($colors) && is_array($colors)) {
    foreach ($colors as $color) {
        echo '
            .apple-'.$color.' {
                background: '.$color.';
            }
            
            .apple-'.$color.':before {
                background: '.$color.';
            }
        ';
    }
}
?> </style>

<div class="row">
    <div class="col-sm-12">
        <?= Html::beginForm(['apple/create-new-tree'], 'post') ?>
        <?= Html::submitButton('Пересоздать набор яблок', ['class' => 'btn btn-success btn-block']) ?>
        <?= Html::endForm() ?>
    </div>
</div>

<div class="row">
    <?php
    foreach ($apples as $apple) {
        ?>
        <div class="col-sm-3 <?= $apple['id'] == $appleId ? ' active-apple ' : '' ?>">
            <div class="apple-container">
                <div class="apple-figure apple-<?= $apple['color'] ?>"></div>
            </div>
            <div class="apple-info">
                <div>Цвет: <?= $apple['color'] ?></div>
                <div>Статус: <?= $apple['statusName'] ?></div>
                <div>Осталось: <?= $apple['currentVolume'] ?></div>
                <div>Дата падения: <?= $apple['fallenDate'] ?></div>

                <?php if ($apple['can_fall']) { ?>
                    <div class="action-block">
                        <div class="action-header">Бросить яблоко на землю</div>
                        <?= Html::beginForm(['apple/apple-fall'], 'post') ?>
                        <?= Html::input('hidden', 'appleId', $apple['id']) ?>
                        <?= Html::submitButton('Бросить', ['class' => 'btn btn-outline-secondary']) ?>
                        <?= Html::endForm() ?>
                    </div>
                <?php }?>

                <?php if ($apple['can_eat']) { ?>
                    <div class="action-block">
                        <div class="action-header">Откусить от яблока %</div>
                        <?= Html::beginForm(['apple/apple-eat'], 'post') ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <?= Html::input('text', 'volume', '30', ['class' => 'form-control']) ?>
                            </div>
                            <div class="col-lg-6">
                                <?= Html::submitButton('Откусить', ['class' => 'btn btn-success btn-block']) ?>
                            </div>
                        </div>
                        <?= Html::input('hidden', 'appleId', $apple['id']) ?>
                        <?= Html::endForm() ?>
                    </div>
                <?php }?>

                <?php if ($apple['errors']) { ?>
                    <div class="alert-danger"><?= $apple['errors'] ?></div>
                <?php }?>

            </div>
        </div>
        <?php
    }
    ?>
</div>
