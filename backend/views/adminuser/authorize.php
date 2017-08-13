<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 12/08/2017
 * Time: 13:42
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $username */
/* @var $currentRoles */
/* @var $allRoles */
$this->title = $username;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = "授权";
?>

<div class="comment-form">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::checkboxList('role', $currentRoles, $allRoles) ?>

    <div class="form-group">
        <?= Html::submitButton('设置', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>