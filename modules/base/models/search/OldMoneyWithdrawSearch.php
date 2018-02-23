<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\OldMoneyWithdraw;

/**
 * OldMoneyWithdrawSearch represents the model behind the search form about `app\modules\base\models\OldMoneyWithdraw`.
 */
class OldMoneyWithdrawSearch extends OldMoneyWithdraw
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['WithdrawalApplicationID', 'AccountID', 'WithdrawalState', 'DealTime', 'CreateTime', 'Trans_batchid', 'Trans_no', 'UserName', 'RealName', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['WithdrawableMoney', 'WithdrawalDisableMoney'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = OldMoneyWithdraw::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'WithdrawableMoney' => $this->WithdrawableMoney,
            'DealTime' => $this->DealTime,
            'CreateTime' => $this->CreateTime,
            'WithdrawalDisableMoney' => $this->WithdrawalDisableMoney,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'WithdrawalApplicationID', $this->WithdrawalApplicationID])
            ->andFilterWhere(['like', 'AccountID', $this->AccountID])
            ->andFilterWhere(['like', 'WithdrawalState', $this->WithdrawalState])
            ->andFilterWhere(['like', 'Trans_batchid', $this->Trans_batchid])
            ->andFilterWhere(['like', 'Trans_no', $this->Trans_no])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'RealName', $this->RealName]);

        return $dataProvider;
    }
}
