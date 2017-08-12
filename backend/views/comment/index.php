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
                'contentOptions' => function ($model) {

                    if ($model->status == 1) {

                        return ['class' => 'bg-info', 'width' => '100px'];
                    } else {

                        return ['width' => '100px'];
                    }
                },
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

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['width' => '5%'],
                'template' => '{view}  {update} {approve}',
                'buttons' => [
                    'approve' => function ($url, $model, $key) {

                        $options = [
                            'title' => Yii::t('yii', "审核"),
                            'aria-label' => Yii::t('yii', "审核"),
                            'data-confirm' => Yii::t('yii', '确定通过这条评论吗？'),
                            'data-method' => 'post',
                            'data-ajax' => '0'];

                        return Html::a('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>', $url, $options);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
