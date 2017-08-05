<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Commentstatus;
use common\models\Remindstatus;
use common\models\Post;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')
        ->dropDownList(Commentstatus::find()
            ->select('name')
            ->indexBy('id')
            ->column()) ?>

    <?= $form->field($model, 'userid')
        ->dropDownList(User::find()
            ->select('username')
            ->indexBy('id')
            ->column()) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'post_id')
        ->dropDownList(Post::find()
            ->select('title')
            ->indexBy('id')
            ->column()) ?>

    <?= $form->field($model, 'remind')
        ->dropDownList(Remindstatus::find()
            ->select('name')
            ->column()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增评论' : '更新评论', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
