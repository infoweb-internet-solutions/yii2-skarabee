<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="fast-search">

    <h1><?= Yii::t('frontend' ,'Zoek in ons aanbod') ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'action' => \yii\helpers\Url::toRoute(['/zoeken']),
        'method' => 'get',
    ]); ?>

    <?php // Flash messages ?>
    <?= Yii::$app->view->render('@app/views/site/_flash_messages'); ?>

    <div class="form-group">
        <?= Html::dropDownList('realEstateCategory', Yii::$app->request->get('realEstateCategory', null),
            \yii\helpers\ArrayHelper::map(\infoweb\skarabee\models\Category::find()->all(), 'id', 'name'), [
            'prompt' => Yii::t('frontend', 'Kies een status'),
            'class' => 'form-control',
        ]) ?>
    </div>

    <?= $form->field($model, 'city')->textInput(['placeholder' => $model->getAttributeLabel('city')])->label(false) ?>

    <div class="form-group">
        <?= Html::dropDownList('realEstateType', Yii::$app->request->get('realEstateType', null),
            \yii\helpers\ArrayHelper::map(\infoweb\skarabee\models\Type::find()->all(), 'id', 'name'), [
                'prompt' => Yii::t('frontend', 'Kies een type'),
                'class' => 'form-control',
            ]) ?>
    </div>

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