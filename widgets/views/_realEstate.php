<?php
use yii\helpers\Html;
use infoweb\skarabee\models\RealEstate;
?>
<?php if ($model->getImage(false)): ?>
<div class="foto" >
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
    <?php /* Hack if here are only 2 images */ ?>
    <?php if (count($model->getImages(['isMain' => 0])) < 2): ?>
    <div class="thumb1">&nbsp;</div>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="foto" style="width: 486px;">
    <?= Html::img($model->getImage(true, '@frontendUrl/uploads/img/placeholder.png')->getUrl('486x208'), ['class' => 'img-responsive center-block']) ?>
</div>
<?php endif; ?>
<div class="info">
    <?php if ($model->price): ?>
    <div class="price">
        <?= Yii::$app->formatter->asCurrency($model->price) ?> <?= (in_array($model->status, RealEstate::combinedStatuses()['te-huur'])) ? ' / maand' : '' ?>
    </div>
    <?php endif; ?>
    <?php if ($model->type): ?>
    <div class="type">
        <?= \infoweb\skarabee\models\RealEstate::types()[$model->type] ?>
    </div>
    <?php endif; ?>
    <?php if ($model->city): ?>
    <div class="location">
        <?= $model->zipcode ?>&nbsp;<?= $model->city ?>
    </div>
    <?php endif; ?>
    <?php if ($model->flash_title): ?>
    <div class="details">
        <?= $model->flash_title ?>
    </div>
    <?php endif; ?>
</div>
<div class="button">
    <?= Html::a('Meer info', 'vastgoed/' . $model->id, ['class' => 'btn button-detail']) ?>
</div>
