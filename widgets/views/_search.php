<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="fast-search">

    <h1><?= Yii::t('frontend' ,'Zoek in ons aanbod') ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'w0-filters',
        //'action' => Url::toRoute('site/search'),
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'street') ?>

    <?php // Flash messages ?>
    <?= Yii::$app->view->render('@app/views/site/_flash_messages'); ?>

    <?= $form->field($model, 'status')->dropDownList([
        'FOR_SALE' => 'Te koop',
        'FOR_RENT' => 'Te huur',
    ], [
        'prompt' => $model->getAttributeLabel('type')
    ])->label(false) ?>

    <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('city')])->label(false) ?>

    <?= $form->field($model, 'market_type')->textInput(['placeholder' => $model->getAttributeLabel('market_type')])->label(false) ?>

    <?php /*
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'price_from')->textInput(['placeholder' => $model->getAttributeLabel('price_from')])->label(false) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'price_to')->textInput(['placeholder' => $model->getAttributeLabel('price_to')])->label(false) ?>
                </div>
            </div>
            */ ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('frontend', 'Zoeken'), ['class' => 'btn btn-danger']) ?>
        <?php /* <?= Html::resetButton(Yii::t('frontend', 'Reset'), ['class' => 'btn btn-default']) ?> */ ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>