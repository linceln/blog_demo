<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '新增管理员';
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-create">

    <?= $this->render('_create', [
        'model' => $model,
    ]) ?>

</div>
