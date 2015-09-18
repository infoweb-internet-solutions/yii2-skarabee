<?php
use yii\helpers\Html;
?>
<div class="foto"><?= Html::img('@web/frontend/web/img/tekoop/foto1.jpg') ?></div>
<div class="thumbs">
    <div class="thumb1">
        <?= Html::img('@web/frontend/web/img/tekoop/foto2.jpg') ?>
    </div>
    <div class="thumb2">
        <?= Html::img('@web/frontend/web/img/tekoop/foto3.jpg') ?>
    </div>
</div>

<div class="info">
    <div class="price">
        €<?= $model->price ?>
    </div>
    <div class="type">
        <?= $model->type ?>
    </div>
    <div class="location">
        <?= $model->zipcode ?>&nbsp;<?= $model->city ?>
    </div>
    <div class="details">
        <?= $model->flash_title ?>
    </div>
</div>
<div class="button">
    <a href="#" class="btn button-detail">Meer info</a>
</div>
