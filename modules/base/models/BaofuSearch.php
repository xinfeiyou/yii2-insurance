<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%baofu_search}}".
 *
 * @property string $id
 * @property string $additional_info
 * @property string $biz_type
 * @property string $data_type
 * @property string $member_id
 * @property string $order_stat
 * @property string $orig_trade_date
 * @property string $orig_trans_id
 * @property string $req_reserved
 * @property string $resp_code
 * @property string $resp_msg
 * @property string $succ_amt
 * @property string $terminal_id
 * @property string $trans_no
 * @property string $trans_serial_no
 * @property string $txn_sub_type
 * @property string $txn_type
 * @property string $version
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class BaofuSearch extends \app\modules\base\models\BaseModel {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%baofu_search}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['additional_info', 'biz_type', 'data_type', 'member_id', 'order_stat', 'orig_trade_date', 'orig_trans_id', 'req_reserved', 'resp_code', 'resp_msg', 'succ_amt', 'terminal_id', 'trans_no', 'trans_serial_no', 'txn_sub_type', 'txn_type', 'version'], 'string', 'max' => 50],
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
            'order_stat' => 'Order Stat',
            'orig_trade_date' => 'Orig Trade Date',
            'orig_trans_id' => 'Orig Trans ID',
            'req_reserved' => 'Req Reserved',
            'resp_code' => 'Resp Code',
            'resp_msg' => 'Resp Msg',
            'succ_amt' => 'Succ Amt',
            'terminal_id' => 'Terminal ID',
            'trans_no' => 'Trans No',
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
        $model = new BaofuSearch();
        $arMsg = $this->create_data($model, $arData);
        return $arMsg;
    }

}
