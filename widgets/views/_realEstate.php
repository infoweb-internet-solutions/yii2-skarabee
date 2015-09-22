<?php
use yii\helpers\Html;
?>
<?php if ($model->getImage(false)): ?>
<div class="foto">
    <?= Html::a(Html::img($model->getImage(false)->getUrl('320x208'), ['class' => 'img-responsive center-block']), $model->getImage(false)->getUrl('1000x'), ['class' => 'fancybox', 'rel' => "real-estate-{$model->id}"]) ?>
</div>
<div class="thumbs">
    <?php foreach ($model->getImages(['isMain' => 0]) as $key => $image): ?>
    <?php if ($key < 2): ?>
    <div class="thumb1">
        <?= Html::a(Html::img($image->getUrl('150x96'), ['class' => 'img-responsive center-block']), $image->getUrl('1000x'), ['class' => 'fancybox', 'rel' => "real-estate-{$model->id}"]) ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="placeholder">
    <?= Html::img('@frontendUrl/img/icon1.png', ['class' => 'img-responsive center-block']) ?>
</div>
<?php endif; ?>
<div class="info">
    <div class="price">
        <?= Yii::$app->formatter->asCurrency($model->price) ?>
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
    <?= Html::a('Meer info', 'vastgoed/' . $model->id, ['class' => 'btn button-detail']) ?>
</div>
