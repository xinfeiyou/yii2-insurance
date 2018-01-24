<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_apply_page}}".
 *
 * @property string $id
 * @property string $strWorkNum
 * @property string $strPage
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkApplyPage extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_apply_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['strWorkNum'], 'required'],
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strWorkNum'], 'string', 'max' => 40],
            [['strPage'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strWorkNum' => '流程编号',
            'strPage' => '当前页数',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 添加当前页记录
     * @param type $strWorkNum
     * @param array $arData
     * @return type
     */
    public function add($strWorkNum,$arData) {
        $model = new WorkApplyPage();
        $arData['strWorkNum'] = $strWorkNum;
        $arMsg = $this->create_data($model, $arData);
        $arMsg['content'] = $arData['strWorkNum'];
        return $arMsg;
    }

    /**
     * 编辑申请资料
     * @param type $strUserId
     * @param type $arData
     * @return type
     */
    public function edit($strWorkNum, $arData) {
        $model = WorkApplyPage::findOne(['strWorkNum' => $strWorkNum]);
        return $this->edit_data($model, $arData);
    }

}
