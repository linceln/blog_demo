<?php

namespace common\models;

use Symfony\Component\Console\Helper\Table;
use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    private static function string2Array($string)
    {
//        return preg_split(',', trim($string), -1, PREG_SPLIT_NO_EMPTY);
        return explode(',', $string);
    }

    private static function array2String($array)
    {
        return implode(', ', $array);
    }

    private static function addTags($tags)
    {
        if (empty($tags)) return;

        foreach ($tags as $name) {

            $tag = Tag::find()->where(['name' => $name])->one();
            $frequency = Tag::find()->where(['name' => $name])->count();

            if ($frequency) {
                $tag->frequency += 1;
                $tag->save();
            } else {
                $tag = new Tag();
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }
        }
    }

    private static function removeTags($tags)
    {
        if (empty($tags)) return;

        foreach ($tags as $name) {

            $tag = Tag::find()->where(['name' => $name])->one();
            $frequency = Tag::find()->where(['name' => $name])->count();

            if ($frequency) {
                if ($tag->frequency <= 1) {
                    $tag->delete();
                } else {
                    $tag->frequency -= 1;
                    $tag->save();
                }
            }

        }
    }

    public static function updateFrequency($oldTags, $newTags)
    {
        if (empty($oldTags) && empty($newTags)) {
            return;
        }

        $oldTagsArray = self::string2Array($oldTags);
        $newTagsArray = self::string2Array($newTags);

        self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
        self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
    }
}
