<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use common\models\Adminuser;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    // 第一种方法
    //    $postStatuses = Poststatus::find()->all();
    //    $allStatuses = ArrayHelper::map($postStatuses, 'id', 'name');

    // 第二种方法
    //    $allStatuses = (new Query())
    //        ->select(['name'])
    //        ->from('poststatus')
    //        ->indexBy('id')
    //        ->column();

    // 第三种方法
//    $allStatuses = Adminuser::find()
//        ->select(['nickname'])
//        ->indexBy('id')
//        ->column();
//
//    echo '<pre>';
//    print_r($allStatuses);
//    echo '</pre>';
//    exit(0);
    ?>

    <!-- 状态下拉列表-->
    <?= $form->field($model, 'status')
        ->dropDownList(Poststatus::find()
            ->select(['name'])
            ->indexBy('id')
            ->column()) ?>

    <!-- 作者下拉列表-->
    <?= $form->field($model, 'author_id')
        ->dropDownList(Adminuser::find()
            ->select(['nickname'])
            ->indexBy('id')
            ->column()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
