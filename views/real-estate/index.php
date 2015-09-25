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
    
    <?php if ($timestamp) : ?>
        <small class="pull-right">(<?= Yii::t('infoweb/skarabee', 'Laatst bijgewerkt op {date} om {time}', ['date' => Yii::$app->formatter->asDate($timestamp['last_synchronisation']), 'time' => Yii::$app->formatter->asTime($timestamp['last_synchronisation'])]) ?>)</small>
        <?php endif; ?>
    
    <?php // Flash messages ?>
    <?php echo $this->render('_flash_messages'); ?>

    <?php // Gridview ?>
    <?php Pjax::begin(['id'=>'grid-pjax']); ?>
    <?php echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\DataColumn',
                'attribute' => 'street',
                'label' => Yii::t('infoweb/skarabee', 'Adres'),
                'value' => function ($model, $index, $widget) {
                    return Html::a($model->getAddress(), $model->getUrl(), ['target' => '_blank', 'data-pjax' => 0]);    
                },
                'format' => 'raw'
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
                    return $model->statuses()[$model->status];
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{downloads}',
                'buttons' => [
                    'downloads' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-th-list"></span>', $url, [
                            'title' => Yii::t('infoweb/skarabee', 'Downloads'),
                            'data-pjax' => '0',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
                'width' => '80px',
            ],
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