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
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\Adminuser', 'message' => '该邮箱已经存在'],

            ['profile', 'trim'],
            ['profile', 'string', 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
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
