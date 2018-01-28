<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_promoter}}".
 *
 * @property string $id
 * @property string $strUserId
 * @property string $strPromoterId
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkPromoter extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%work_promoter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['strUserId', 'strPromoterId'], 'required'],
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId', 'strPromoterId'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'strUserId' => '业务员ID',
            'strPromoterId' => '推广员ID',
            'tCreateTime' => '创建时间',
            'tUpdateTime' => '更新时间',
        ];
    }

    /**
     * 添加推广人数据
     * @param array $arData
     * @return type
     */
    public function add($arData) {
        $model = new WorkPromoter();
        $arMsg = $this->create_data($model, $arData);
        return $arMsg;
    }

    /**
     * 获取地下推广人信息列
     * @param type $strUserId
     */
    public function getPromoterList($strUserId) {
        $arObj = WorkPromoter::find()
                ->where(['strUserId' => $strUserId])
                ->all();
        $arData = [];
        if (!empty($arObj)) {
            $i = 0;
            foreach ($arObj as $obj) {
                $arData[$i]['id'] = $i;
                $arData[$i]['faceSrc'] = $obj->promoter->avatarUrl;
                $arData[$i]['strUserId'] = $obj->promoter->strUserId;
                $arData[$i]['phone'] = $obj->promoter->strPhone;
                $arData[$i]['user'] = $obj->promoter->nickName;
                $arData[$i]['detailsEvent'] = 'detailsEvent';
                $arData[$i]['eventParams'] = '{"inner_page_link":"\/pages\/workHistory\/workHistory","is_redirect":0}';
                $i++;
            }
        }
        return $this->setReturnMsg('0000', $arData);
    }

    /**
     * 获取地下推广人信息列
     * @return type
     */
    public function getPromoter() {
        return $this->hasOne(WorkUser::className(), ['strUserId' => 'strPromoterId']);
    }

}
