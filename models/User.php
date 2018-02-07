<?php

namespace app\models;

use app\modules\base\models\WorkAdmin;

class User extends \yii\base\Object implements \yii\web\IdentityInterface {

    public $strUserId;
    public $realname;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $EIsAdmin;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        $user = self::getUserInfo(['strUserId' => $id]);
        return empty($user) ? null : new static($user);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        $user = self::getUserInfo(['accessToken' => $token]);
        return empty($user) ? null : new static($user);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        $user = self::getUserInfo(['username' => $username]);
        return empty($user) ? null : new static($user);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->strUserId;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return $this->password === md5($password);
    }

    /**
     * 获取员工信息
     * @param array $arWhere    条件
     * @return array
     */
    public static function getUserInfo($arWhere) {
        if (empty($arWhere)) {
            return null;
        }
        $user = WorkAdmin::find()
                ->select(['strUserId', 'username', 'password', 'authKey', 'accessToken', 'realname', 'EIsAdmin'])
                ->where($arWhere)
                ->asArray()
                ->one();
        return $user;
    }

}
