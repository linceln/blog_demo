<?php

namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class ResetPasswordForm extends Model
{
    public $username;
    public $nickname;
    public $password;
    public $passwordRepeat;

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'passwordRepeat' => '确认密码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6],

            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Reset password.
     *
     * @return Adminuser|null the saved model or null if saving fails
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $adminuser = Adminuser::findOne($id);
        $adminuser->setPassword($this->password);
        $adminuser->generateAuthKey();

        return $adminuser->save() ? $adminuser : null;
    }

    public function fillData($id)
    {
        $adminuser = Adminuser::findOne($id);
        $this->username = $adminuser->username;
        $this->nickname = $adminuser->nickname;
    }
}
