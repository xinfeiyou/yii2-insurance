<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\OldOrderList;

/**
 * OldOrderListSearch represents the model behind the search form about `app\modules\base\models\OldOrderList`.
 */
class OldOrderListSearch extends OldOrderList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['OrderID', 'OrderType', 'ProjectID', 'AccountID', 'PreviousRepaymentDate', 'CreateTime', 'SettlementPeriod', 'tCreateTime', 'tUpdateTime','UserName','RealName'], 'safe'],
            [['ExtraRate', 'Amount', 'ExtraMoney'], 'number'],
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
    public function search($params,$ProjectID = "")
    {
        $query = OldOrderList::find();
        if(!empty($ProjectID)){
            $query->andWhere(['ProjectID'=>$ProjectID]);
        }
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
            'ExtraRate' => $this->ExtraRate,
            'Amount' => $this->Amount,
            'PreviousRepaymentDate' => $this->PreviousRepaymentDate,
            'CreateTime' => $this->CreateTime,
            'ExtraMoney' => $this->ExtraMoney,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'OrderID', $this->OrderID])
            ->andFilterWhere(['like', 'OrderType', $this->OrderType])
            ->andFilterWhere(['like', 'ProjectID', $this->ProjectID])
            ->andFilterWhere(['like', 'AccountID', $this->AccountID])
            ->andFilterWhere(['like', 'SettlementPeriod', $this->SettlementPeriod]);

        return $dataProvider;
    }
}
