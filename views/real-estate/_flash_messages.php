<?php if (Yii::$app->getSession()->hasFlash('rehabilitation')): ?>
<div class="alert alert-success">
    <p><?= Yii::$app->getSession()->getFlash('rehabilitation') ?></p>
</div>
<?php endif; ?>

<?php if (Yii::$app->getSession()->hasFlash('rehabilitation-error')): ?>
<div class="alert alert-danger">
    <p><?= Yii::$app->getSession()->getFlash('rehabilitation-error') ?></p>
</div>
<?php endif; ?>