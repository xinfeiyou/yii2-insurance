<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\OldMoneyLine;

/**
 * OldMoneyLineSearch represents the model behind the search form about `app\modules\base\models\OldMoneyLine`.
 */
class OldMoneyLineSearch extends OldMoneyLine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['AddMoneyApplicationID', 'AccountID', 'ManagerID', 'State', 'DealTime', 'CreateTime', 'UserName', 'RealName', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['Money'], 'number'],
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
        $query = OldMoneyLine::find();

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
            'DealTime' => $this->DealTime,
            'CreateTime' => $this->CreateTime,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'AddMoneyApplicationID', $this->AddMoneyApplicationID])
            ->andFilterWhere(['like', 'AccountID', $this->AccountID])
            ->andFilterWhere(['like', 'ManagerID', $this->ManagerID])
            ->andFilterWhere(['like', 'State', $this->State])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'RealName', $this->RealName]);

        return $dataProvider;
    }
}
