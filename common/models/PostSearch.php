<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Post;

/**
 * PostSearch represents the model behind the search form about `common\models\Post`.
 */
class PostSearch extends Post
{

    public function attributes()
    {
        return array_merge(parent::attributes(), ['author_name']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'create_time', 'update_time', 'author_id'], 'integer'],
            [['title', 'content', 'tags', 'author_name'], 'safe'],
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
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 分页
            'pagination' => ['pageSize' => 10],
            'sort' => [
                // 默认排序的字段
                'defaultOrder' => [
                    'update_time' => SORT_DESC
                ],
                // 需要排序的字段
//                'attributes' => [
//                    'id',
//                    'create_time'
//                ]
            ],
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
            'status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'tags', $this->tags]);

        // 建立表连接
        $query->join('INNER JOIN', 'adminuser', 'post.author_id = adminuser.id')
            ->andFilterWhere(['like', 'adminuser.nickname', $this->author_name]);

        // 添加需要排序的字段
        $dataProvider->sort->attributes['author_name'] = [
            'asc' => ['adminuser.nickname' => SORT_ASC],
            'desc' => ['adminuser.nickname' => SORT_DESC],
        ];

        return $dataProvider;
    }
}
