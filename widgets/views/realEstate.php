<?php
use yii\widgets\Pjax;
?>

<?php

Pjax::begin([
    'id' => 'real-estate-items',
    'timeout' => 5000,
]);

echo $this->render('_search', ['model' => $searchModel, 'searchOnly' => $searchOnly]);

if (!$searchOnly) {
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => $template,
        'viewParams' => [

        ],
        'itemOptions' => [
            'class' => 'tekoop-item',
        ],
        'layout' => $layout,
    ]);
}

Pjax::end();