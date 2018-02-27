<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\OldProjectList;

/**
 * OldProjectListSearch represents the model behind the search form about `app\modules\base\models\OldProjectList`.
 */
class OldProjectListSearch extends OldProjectList
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'RepaymentDuration', 'InterestDate'], 'integer'],
            [['ProjectID', 'ProjectType', 'Title', 'FundraisingBeginTime', 'FundraisingEndTime', 'RepaymentType', 'Safeguards', 'BorrowerInformation', 'ProjectState', 'CreateTime', 'tCreateTime', 'tUpdateTime'], 'safe'],
            [['TargetAmount', 'MonthlyReturnRate', 'ExtraMonthlyReturnRate'], 'number'],
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
        $query = OldProjectList::find();

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
            'TargetAmount' => $this->TargetAmount,
            'MonthlyReturnRate' => $this->MonthlyReturnRate,
            'RepaymentDuration' => $this->RepaymentDuration,
            'FundraisingBeginTime' => $this->FundraisingBeginTime,
            'FundraisingEndTime' => $this->FundraisingEndTime,
            'InterestDate' => $this->InterestDate,
            'CreateTime' => $this->CreateTime,
            'ExtraMonthlyReturnRate' => $this->ExtraMonthlyReturnRate,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'ProjectID', $this->ProjectID])
            ->andFilterWhere(['like', 'ProjectType', $this->ProjectType])
            ->andFilterWhere(['like', 'Title', $this->Title])
            ->andFilterWhere(['like', 'RepaymentType', $this->RepaymentType])
            ->andFilterWhere(['like', 'Safeguards', $this->Safeguards])
            ->andFilterWhere(['like', 'BorrowerInformation', $this->BorrowerInformation])
            ->andFilterWhere(['like', 'ProjectState', $this->ProjectState]);

        return $dataProvider;
    }
}
