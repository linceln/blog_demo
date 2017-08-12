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

$this->title = "修改密码";
$this->params['breadcrumbs'][] = ['label' => "管理员", 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="adminuser-form">

    <h2><?= Html::encode($model->username) . '（' . Html::encode($model->nickname) . ')' ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passwordRepeat')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('修改密码', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>