<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '100px']
            ],
            [
                'attribute' => 'username',
                'contentOptions' => ['width' => '200px']
            ],
            [
                'attribute' => 'status',
                'contentOptions' => ['width' => '100px'],
                'value' => function ($model) {
                    return $model->status == User::STATUS_ACTIVE ? '激活' : '禁用';
                },
                'filter' => [User::STATUS_ACTIVE => '激活', User::STATUS_DELETED => '禁用']
            ],
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['width' => '1%'],
                'template' => '{update}'
            ],

        ],
    ]); ?>
</div>
