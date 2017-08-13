<?php

namespace common\models;

use function foo\func;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    const AUTHOR_NAME = 'post.author.nickname';

    public function attributes()
    {
        return array_merge(parent::attributes(), ['user.username', 'post.title', CommentSearch::AUTHOR_NAME]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'userid', 'post_id', 'remind'], 'integer'],
            [['content', 'email', 'url', 'user.username', 'post.title', CommentSearch::AUTHOR_NAME], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Comment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'comment.status' => $this->status,
            'create_time' => $this->create_time,
            'userid' => $this->userid,
            'post_id' => $this->post_id,
            'remind' => $this->remind,
        ]);

        $query->andFilterWhere(['like', 'comment.content', $this->content])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'url', $this->url]);

        // 建立表连接
        $query->joinWith('user', true, 'INNER JOIN')
            ->andFilterWhere(['like', 'user.username', $this->getAttribute('user.username')]);

        $query->joinWith('post', true, 'INNER JOIN')
            ->andFilterWhere(['like', 'post.title', $this->getAttribute('post.title')]);

        $query->joinWith([
            'post' => function (ActiveQuery $query) {

//                $query->joinWith('adminuser', true, 'INNER JOIN')
                $query->join('INNER JOIN', 'adminuser', 'post.author_id = adminuser.id')
                        ->andFilterWhere(['like', 'adminuser.nickname', $this->getAttribute(CommentSearch::AUTHOR_NAME)])
                    ->andWhere(['adminuser.id' => Yii::$app->user->id]);

            }
        ], true, 'INNER JOIN');

        // 添加需要排序的字段
        $dataProvider->sort->attributes['user.username'] = [
            'asc' => ['username' => SORT_ASC],
            'desc' => ['username' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['post.title'] = [
            'asc' => ['post.title' => SORT_ASC],
            'desc' => ['post.title' => SORT_DESC],
        ];

        $dataProvider->sort->attributes[CommentSearch::AUTHOR_NAME] = [
            'asc' => [CommentSearch::AUTHOR_NAME => SORT_ASC],
            'desc' => [CommentSearch::AUTHOR_NAME => SORT_DESC],
        ];

        return $dataProvider;
    }
}
