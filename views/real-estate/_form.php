<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

?>

<div class="real-estate-form">

    <?php // Flash messages ?>
    <?php echo $this->render('_flash_messages'); ?>
    
    <?php
    // Init the form
    $form = ActiveForm::begin([
        'id'                        => 'real-estate-form',
        'options'                   => ['class' => 'tabbed-form'],
        'enableAjaxValidation'      => true,
        'enableClientValidation'    => false,       
    ]);

    // Initialize the tabs
    $tabs = [];
    
    // Add the main tabs
    $tabs = [
        [
            'label' => Yii::t('infoweb/skarabee', 'Downloads'),
            'content' => $this->render('_downloads_tab', ['model' => $model, 'form' => $form]),
            'active' => true,
        ]
    ];
    
    // Display the tabs
    echo Tabs::widget(['items' => $tabs]);   
    ?>
    
    <div class="form-group buttons">    
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton(Yii::t('app', 'Update & close'), ['class' => 'btn btn-default', 'name' => 'close']) ?>
        <?= Html::a(Yii::t('app', 'Close'), ['index'], ['class' => 'btn btn-danger']) ?>    
    </div>

    <?php ActiveForm::end(); ?>

</div>