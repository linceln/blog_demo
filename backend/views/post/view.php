<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '文章详情';
?>
<div class="post-view">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width: 100px;">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'title',
            'tags:ntext',
//            'status',
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
//            'create_time:datetime',
            [
                'attribute' => 'create_time',
                'value' => date('Y-h-d H:i:s', $model->create_time),
            ],
//            'update_time:datetime',
            [
                'attribute' => 'update_time',
                'value' => date('Y-h-d H:i:s', $model->update_time),
            ],
//            'author_id',
            [
                'attribute' => 'author_id',
                'value' => $model->author->nickname,

            ],
            'content:html',
        ],
    ]) ?>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除这篇文章吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
