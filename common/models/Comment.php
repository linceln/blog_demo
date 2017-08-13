<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $userid
 * @property string $email
 * @property string $url
 * @property integer $post_id
 * @property integer $remind
 *
 * @property Post $post
 * @property Commentstatus $status0
 * @property User $user
 * @property Remindstatus $remind0
 */
class Comment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id', 'remind'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '创建时间',
            'userid' => '用户',
            'email' => '邮箱',
            'url' => '链接',
            'post_id' => '文章',
            'remind' => '通知',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemind0()
    {
        return $this->hasOne(Remindstatus::className(), ['id' => 'remind']);
    }

    public function getShortContent()
    {
        $content = $this->content;
        $str = strip_tags($content);
        $strLen = mb_strlen($str);

        return mb_substr($str, 0, 10, 'utf-8') . ($strLen > 10 ? '...' : '');
    }

    public function beforeSave($insert)
    {
        $this->create_time = time();
        return parent::beforeSave($insert);
    }

    public function approve()
    {
        $this->status = 2;
        return $this->save();
    }

    /**
     * 待审核评论条数
     * @return int|string
     */
    public static function getPendingCommentCount()
    {
        return Comment::find()
            ->joinWith([
                'post' => function (ActiveQuery $query) {

                    $query->join('INNER JOIN', 'adminuser', 'post.author_id = adminuser.id')
                        ->andWhere(['adminuser.id' => Yii::$app->user->id]);

                }
            ], true, 'INNER JOIN')
            ->where('comment.status = 1')
            ->count();
    }

}
