<?php
use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
?>
<div class="tab-content downloads-tab">
    <?= $form->field($model, 'downloads')->widget(CKEditor::className(), [
        'editorOptions' => ArrayHelper::merge(Yii::$app->getModule('cms')->getCKEditorOptions(), ['height' => 200]),
    ]); ?>
</div>