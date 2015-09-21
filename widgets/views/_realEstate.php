<?php
use yii\helpers\Html;
?>
<div class="foto">
    <?= Html::a(Html::img($model->getImage()->getUrl('320x208'), ['class' => 'img-responsive center-block']), $model->getImage()->getUrl('1000x'), ['class' => 'fancybox', 'rel' => "real-estate-{$model->id}"]) ?>
</div>
<div class="thumbs">
    <div class="thumb1">
        <?= Html::a(Html::img($model->getImage()->getUrl('150x96'), ['class' => 'img-responsive center-block']), $model->getImage()->getUrl('1000x'), ['class' => 'fancybox', 'rel' => "real-estate-{$model->id}"]) ?>
    </div>
    <div class="thumb2">
        <?= Html::a(Html::img($model->getImage()->getUrl('150x96'), ['class' => 'img-responsive center-block']), $model->getImage()->getUrl('1000x'), ['class' => 'fancybox', 'rel' => "real-estate-{$model->id}"]) ?>
    </div>
</div>

<div class="info">
    <div class="price">
        &euro;<?= $model->price ?>
    </div>
    <div class="type">
        <?= \infoweb\skarabee\models\RealEstate::types()[$model->type] ?>
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
