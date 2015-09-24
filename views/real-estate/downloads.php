<?php
use yii\helpers\Html;

$this->title = $model->fullAddress;
$this->params['breadcrumbs'][] = ['label' => Yii::t('infoweb/skarabee', 'Vastgoed'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullAddress, 'url' => ['downloads', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('infoweb/skarabee', 'Downloads');
?>
<div class="real-estate-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
