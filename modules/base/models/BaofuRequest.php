<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%baofu_request}}".
 *
 * @property integer $id
 * @property integer $txn_sub_type
 * @property string $biz_type
 * @property string $terminal_id
 * @property string $member_id
 * @property string $trans_serial_no
 * @property string $trade_date
 * @property string $additional_info
 * @property string $req_reserved
 * @property string $pay_code
 * @property string $pay_cm
 * @property string $acc_no
 * @property string $id_card_type
 * @property string $id_card
 * @property string $id_holder
 * @property string $mobile
 * @property string $valid_date
 * @property string $valid_no
 * @property string $trans_id
 * @property integer $txn_amt
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class BaofuRequest extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%baofu_request}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['txn_sub_type', 'txn_amt'], 'integer'],
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['biz_type', 'terminal_id', 'member_id', 'trans_serial_no', 'trade_date', 'additional_info', 'req_reserved', 'pay_code', 'pay_cm', 'acc_no', 'id_card_type', 'id_card', 'id_holder', 'mobile', 'valid_date', 'valid_no', 'trans_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'txn_sub_type' => 'Txn Sub Type',
            'biz_type' => 'Biz Type',
            'terminal_id' => 'Terminal ID',
            'member_id' => 'Member ID',
            'trans_serial_no' => 'Trans Serial No',
            'trade_date' => 'Trade Date',
            'additional_info' => 'Additional Info',
            'req_reserved' => 'Req Reserved',
            'pay_code' => 'Pay Code',
            'pay_cm' => 'Pay Cm',
            'acc_no' => 'Acc No',
            'id_card_type' => 'Id Card Type',
            'id_card' => 'Id Card',
            'id_holder' => 'Id Holder',
            'mobile' => 'Mobile',
            'valid_date' => 'Valid Date',
            'valid_no' => 'Valid No',
            'trans_id' => 'Trans ID',
            'txn_amt' => 'Txn Amt',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }

    /**
     * 添加数据
     * @param array $arData
     * @return type
     */
    public function add($arData) {
        $model = new BaofuRequest();
        $arMsg = $this->create_data($model, $arData);
        return $arMsg;
    }

}
