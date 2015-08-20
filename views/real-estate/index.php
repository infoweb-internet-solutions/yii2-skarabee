<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$this->title = Yii::t('infoweb/skarabee', 'Vastgoed');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="location-index">

    <?php // Title ?>
    <h1>
        <?= Html::encode($this->title) ?>
    </h1>
    
    <?php // Flash messages ?>
    <?php echo $this->render('_flash_messages'); ?>

    <?php // Gridview ?>
    <?php Pjax::begin(['id'=>'grid-pjax']); ?>
    <?php echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'street',
                'label' => Yii::t('infoweb/skarabee', 'Adres'),
                'value' => function ($model, $index, $widget) {
                    return $model->getAddress();    
                }
            ],
            [
                'attribute' => 'zipcode',
                'label' => Yii::t('infoweb/skarabee', 'Gemeente'),
                'value' => function ($model, $index, $widget) {
                    return "{$model->zipcode} {$model->city}";    
                }
            ],            
            [
                'attribute' => 'type',
                'label' => Yii::t('infoweb/skarabee', 'Type'),
                'value' => function ($model, $index, $widget) {
                    return $model->types()[$model->type];    
                }
            ],
            [
                'attribute' => 'status',
                'label' => Yii::t('infoweb/skarabee', 'Status'),
                'value' => function ($model, $index, $widget) {
                    return $model->statusses()[$model->status];    
                }
            ]
        ],
        'responsive' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop' => 88],
        'hover' => true,
        'export' => false,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>