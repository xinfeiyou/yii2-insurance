<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkOdd;

/**
 * WorkOddSearch represents the model behind the search form about `app\modules\base\models\WorkOdd`.
 */
class WorkOddSearch extends WorkOdd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'oddBorrowPeriod', 'isCr', 'receiptStatus', 'finishType'], 'integer'],
            [['oddNumber', 'oddType', 'oddTitle', 'oddRepaymentStyle', 'oddTrialTime', 'oddRehearTime', 'userId', 'operator', 'receiptUserId', 'finishTime'], 'safe'],
            [['oddYearRate', 'oddMoney', 'serviceFee', 'offlineMoney', 'offlineRate'], 'number'],
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
        $query = WorkOdd::find();

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
            'oddYearRate' => $this->oddYearRate,
            'oddMoney' => $this->oddMoney,
            'oddBorrowPeriod' => $this->oddBorrowPeriod,
            'serviceFee' => $this->serviceFee,
            'oddTrialTime' => $this->oddTrialTime,
            'oddRehearTime' => $this->oddRehearTime,
            'offlineMoney' => $this->offlineMoney,
            'offlineRate' => $this->offlineRate,
            'isCr' => $this->isCr,
            'receiptStatus' => $this->receiptStatus,
            'finishType' => $this->finishType,
            'finishTime' => $this->finishTime,
        ]);

        $query->andFilterWhere(['like', 'oddNumber', $this->oddNumber])
            ->andFilterWhere(['like', 'oddType', $this->oddType])
            ->andFilterWhere(['like', 'oddTitle', $this->oddTitle])
            ->andFilterWhere(['like', 'oddRepaymentStyle', $this->oddRepaymentStyle])
            ->andFilterWhere(['like', 'userId', $this->userId])
            ->andFilterWhere(['like', 'operator', $this->operator])
            ->andFilterWhere(['like', 'receiptUserId', $this->receiptUserId]);

        return $dataProvider;
    }
}
