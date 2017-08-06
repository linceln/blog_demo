<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 10/08/2017
 * Time: 06:50
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adminuser-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('修改资料', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>