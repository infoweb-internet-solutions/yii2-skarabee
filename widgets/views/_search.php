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
        'options' => ['data-pjax' => ($searchOnly) ? false : true],
    ]); ?>

    <?php // Flash messages ?>
    <?= Yii::$app->view->render('@app/views/site/_flash_messages'); ?>

    <div class="form-group">
        <?= Html::dropDownList('realEstateCategory', Yii::$app->request->get('realEstateCategory', null),
            \yii\helpers\ArrayHelper::map(\infoweb\skarabee\models\Category::find()->all(), 'id', 'name'), [
            'prompt' => Yii::t('frontend', 'Kies een status'),
            'class' => 'form-control',
            'id' => 'real-estate-category',
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

    <div class="prices-sale row">
        <div class="col-sm-6">
            <?= $form->field($model, 'minPrice')->dropDownList(Yii::$app->params['minPricesForSale'], [
                'prompt' => Yii::t('frontend', 'Prijs van'),
                'encode' => false,
                ])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'maxPrice')->dropDownList(Yii::$app->params['maxPricesForSale'], [
                'prompt' => Yii::t('frontend', 'Prijs tot'),
                'encode' => false,
                ])->label(false) ?>
        </div>
    </div>

    <div class="prices-rent row hidden">
        <div class="col-sm-6">
            <?= $form->field($model, 'minPrice')->dropDownList(Yii::$app->params['minPricesForRent'], [
                'prompt' => Yii::t('frontend', 'Prijs van'),
                'disabled' => true,
                'encode' => false,
            ])->label(false) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'maxPrice')->dropDownList(Yii::$app->params['maxPricesForRent'], [
                'prompt' => Yii::t('frontend', 'Prijs tot'),
                'disabled' => true,
                'encode' => false,
            ])->label(false) ?>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-sm-offset-6 col-sm-6">
            <?= Html::submitButton(Yii::t('frontend', 'Zoeken'), ['class' => 'btn btn-danger form-control']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>