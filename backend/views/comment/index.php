<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Commentstatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px']
            ],
            [
                'attribute' => 'content',
                'value' => 'shortContent',
            ],
            [
//                'attribute' => 'userid',
                'attribute' => 'user.username',
                'label' => '用户',
                'value' => 'user.username'
            ],
            [
                'attribute' => 'status',
                'value' => 'status0.name',
                'contentOptions' => ['width' => '100px'],
                'filter' => Commentstatus::find()
                    ->select('name')
                    ->indexBy('id')
                    ->column()
            ],

            [
                'attribute' => 'create_time',
                'format' => ['date', 'php:Y-m-d H:i:s']
            ],
            [
                'attribute' => 'post.title',
                'label' => '文章',
                'value' => 'post.title'
            ],
            // 'post_id',
            // 'email:email',
            // 'url:url',
            // 'remind',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
