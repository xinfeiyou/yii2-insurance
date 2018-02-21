<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_user_withhold}}".
 *
 * @property string $id
 * @property string $strUserId
 * @property string $strBankCode
 * @property string $strBankNum
 * @property string $strUserCode
 * @property string $strRealName
 * @property string $strUserPhone
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkUserWithhold extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_user_withhold}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId', 'strBankCode', 'strUserCode', 'strRealName', 'strUserPhone', 'strBankName', 'strStatus'], 'string', 'max' => 40],
            [['strBankNum'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strUserId' => '用户ID',
            'strBankName' => '银行名称',
            'strBankCode' => '银行编码',
            'strBankNum' => '银行卡号',
            'strUserCode' => '身份证号',
            'strRealName' => '真实姓名',
            'strUserPhone' => '手机号码',
            'strStatus' => '是否成功',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 添加数据
     * @param type $strUserId   用户ID
     * @param type $arData      数据
     */
    public function add($strUserId, $arData) {
        $model = WorkUserWithhold::findOne(['strUserId' => $strUserId]);
        if (empty($model)) {
            $arData['strUserId'] = $strUserId;
            return $this->create_data((new WorkUserWithhold()), $arData);
        } else {
            return $this->edit_data($model, $arData);
        }
    }

}
