<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

$this->title = $model->post->title;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = "查看评论";
?>
<div class="comment-view">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th style="width: 100px">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            [
                'attribute' => 'title',
                'label' => '标题',
                'value' => $model->post->title,
            ],
            [
                'attribute' => 'status',
                'value' => $model->status0->name,
            ],
            [
                'attribute' => 'create_time',
                'value' => date('Y-m-d H:i:s', $model->create_time),
            ],
            [
                'attribute' => 'userid',
                'value' => $model->user->username,
            ],
            'email:email',
            'url:url',
//            'post_id',
//            [
//                'attribute' => 'post_id',
//                'value' => $model->post->title,
//            ],
//            'remind',
            [
                'attribute' => 'remind',
                'value' => $model->remind0->name,
            ],
            'content:html',
        ],
    ]) ?>

    <p>
        <?= Html::a('修改评论', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '您确定要删除这条评论吗?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
