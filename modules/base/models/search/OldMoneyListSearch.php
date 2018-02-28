<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\OldMoneyList;

/**
 * OldMoneyListSearch represents the model behind the search form about `app\modules\base\models\OldMoneyList`.
 */
class OldMoneyListSearch extends OldMoneyList {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['FundRecordID', 'FundRecordType', 'AccountID', 'Content', 'UserName', 'RealName', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['Money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params, $Content = "", $FundRecordType = "") {
        $query = OldMoneyList::find();
        if (!empty($Content)) {
            $this->Content = $Content;
        }
        if (!empty($FundRecordType)) {
            $this->FundRecordType = $FundRecordType;
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
            'Money' => $this->Money,
            'CreateTime' => $this->CreateTime,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'FundRecordID', $this->FundRecordID])
                ->andFilterWhere(['FundRecordType' => $this->FundRecordType])
                ->andFilterWhere(['like', 'AccountID', $this->AccountID])
                ->andFilterWhere(['like', 'Content', $this->Content])
                ->andFilterWhere(['like', 'UserName', $this->UserName])
                ->andFilterWhere(['like', 'RealName', $this->RealName]);

        return $dataProvider;
    }

}
