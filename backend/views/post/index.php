<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '30px'],
            ],
            'title',
            [
                'attribute' => 'author_name',
                'label' => '作者',
                'value' => 'author.nickname'
            ],
            'tags:ntext',
            [
                'attribute' => 'status',
                'value' => 'status0.name',
                'contentOptions' => ['width' => '100px'],
                'filter' => Poststatus::find()
                    ->select('name')
                    ->indexBy('id')
                    ->column(),
            ],
            [
                'attribute' => 'update_time',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['width' => '5%']
            ],
        ],
    ]); ?>
</div>
