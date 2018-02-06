<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%baofu_result}}".
 *
 * @property string $id
 * @property string $additional_info
 * @property string $biz_type
 * @property string $data_type
 * @property string $member_id
 * @property string $req_reserved
 * @property string $resp_code
 * @property string $resp_msg
 * @property string $terminal_id
 * @property string $trade_date
 * @property string $trans_id
 * @property string $trans_serial_no
 * @property string $txn_sub_type
 * @property string $txn_type
 * @property string $version
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class BaofuResult extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%baofu_result}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['additional_info', 'biz_type', 'data_type', 'member_id', 'req_reserved', 'resp_code', 'resp_msg', 'terminal_id', 'trade_date', 'trans_id', 'trans_serial_no', 'txn_sub_type', 'txn_type', 'version'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'additional_info' => 'Additional Info',
            'biz_type' => 'Biz Type',
            'data_type' => 'Data Type',
            'member_id' => 'Member ID',
            'req_reserved' => 'Req Reserved',
            'resp_code' => 'Resp Code',
            'resp_msg' => 'Resp Msg',
            'terminal_id' => 'Terminal ID',
            'trade_date' => 'Trade Date',
            'trans_id' => 'Trans ID',
            'trans_serial_no' => 'Trans Serial No',
            'txn_sub_type' => 'Txn Sub Type',
            'txn_type' => 'Txn Type',
            'version' => 'Version',
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
        $model = new BaofuResult();
        $arMsg = $this->create_data($model, $arData);
        return $arMsg;
    }

}
