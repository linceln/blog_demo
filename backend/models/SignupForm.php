<?php

namespace backend\models;

use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $nickname;
    public $email;
    public $profile;
    public $password;
    public $passwordRepeat;

    public function attributeLabels()
    {
        return [

            'username' => '用户名',
            'nickname' => '昵称',
            'email' => '邮箱',
            'profile' => '资料',
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
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该用户名已经存在'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该邮箱已经存在'],
            ['email', 'string', 'max' => 255],

            ['profile', 'trim'],
            ['profile', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'string', 'min' => 6],

            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * Signs user up.
     *
     * @return Adminuser|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $adminuser = new Adminuser();
        $adminuser->username = $this->username;
        $adminuser->nickname = $this->nickname;
        $adminuser->email = $this->email;
        $adminuser->profile = $this->profile;
        $adminuser->setPassword($this->password);
        $adminuser->generateAuthKey();

        return $adminuser->save() ? $adminuser : null;
    }
}
