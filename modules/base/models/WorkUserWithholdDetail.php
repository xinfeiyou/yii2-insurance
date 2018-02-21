<?php

namespace app\modules\base\models;

use Yii;

/**
 * This is the model class for table "{{%work_user_withhold_detail}}".
 *
 * @property string $id
 * @property string $strUserId
 * @property string $strBankCode
 * @property string $strBankNum
 * @property string $strUserCode
 * @property string $strRealName
 * @property string $strUserPhone
 * @property double $strUserMoney
 * @property string $additional_info
 * @property string $biz_type
 * @property string $data_type
 * @property string $member_id
 * @property string $req_reserved
 * @property string $resp_code
 * @property string $resp_msg
 * @property string $succ_amt
 * @property string $terminal_id
 * @property string $trade_date
 * @property string $trans_id
 * @property string $trans_no
 * @property string $trans_serial_no
 * @property string $txn_sub_type
 * @property string $txn_type
 * @property string $version
 * @property string $strJson
 * @property string $tCreateTime
 * @property string $tUpdateTime
 */
class WorkUserWithholdDetail extends \app\modules\base\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_user_withhold_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['strUserMoney'], 'number'],
            [['strJson'], 'string'],
            [['tCreateTime', 'tUpdateTime'], 'safe'],
            [['strUserId', 'strBankCode', 'strUserCode', 'strRealName', 'strUserPhone', 'biz_type', 'data_type', 'member_id', 'req_reserved', 'resp_code', 'resp_msg', 'succ_amt', 'terminal_id', 'trade_date', 'trans_id', 'trans_no', 'trans_serial_no', 'txn_sub_type', 'txn_type', 'version'], 'string', 'max' => 40],
            [['strBankNum', 'additional_info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'strUserId' => 'Str User ID',
            'strBankCode' => 'Str Bank Code',
            'strBankNum' => 'Str Bank Num',
            'strUserCode' => 'Str User Code',
            'strRealName' => 'Str Real Name',
            'strUserPhone' => 'Str User Phone',
            'strUserMoney' => 'Str User Money',
            'additional_info' => 'Additional Info',
            'biz_type' => 'Biz Type',
            'data_type' => 'Data Type',
            'member_id' => 'Member ID',
            'req_reserved' => 'Req Reserved',
            'resp_code' => 'Resp Code',
            'resp_msg' => 'Resp Msg',
            'succ_amt' => 'Succ Amt',
            'terminal_id' => 'Terminal ID',
            'trade_date' => 'Trade Date',
            'trans_id' => 'Trans ID',
            'trans_no' => 'Trans No',
            'trans_serial_no' => 'Trans Serial No',
            'txn_sub_type' => 'Txn Sub Type',
            'txn_type' => 'Txn Type',
            'version' => 'Version',
            'strJson' => 'Str Json',
            'tCreateTime' => 'T Create Time',
            'tUpdateTime' => 'T Update Time',
        ];
    }
}
