<?php
use yii\widgets\Pjax;
?>

<?php

Pjax::begin([
    'id' => 'real-estate-items',
    'timeout' => 3000,
]);

echo \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => $template,
    'viewParams' => [

    ],
    'summary' => false,
    'itemOptions' => [
        'class' => 'tekoop-item',
    ],
    'layout' => $layout,
]);

Pjax::end();