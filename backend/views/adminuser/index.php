<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">
    <p>
        <?= Html::a('新增管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['width' => '100px'],
            ],
            [
                'attribute' => 'username',
                'contentOptions' => ['width' => '200px'],
            ],
            [
                'attribute' => 'nickname',
                'contentOptions' => ['width' => '200px'],
            ],
            'email:email',

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['width' => '5%'],
                'template' => '{view} {update} {password} {authorize}',
                'buttons' => [
                    'authorize' => function ($url, $model, $key) {

                        $options = [
                            'title' => Yii::t('yii', "授权"),
                            'aria-label' => Yii::t('yii', "授权"),
                            'data-method' => 'post',
                            'data-ajax' => '0'
                        ];

                        return Html::a('<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>', $url, $options);
                    },

                    'password' => function($url, $model, $key){
                        $options = [
                            'title' => Yii::t('yii', "修改密码"),
                            'aria-label' => Yii::t('yii', "修改密码"),
                            'data-method' => 'post',
                            'data-ajax' => '0'
                        ];

                        return Html::a('<span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>', $url, $options);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
