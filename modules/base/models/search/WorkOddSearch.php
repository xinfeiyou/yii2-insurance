<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkOdd;
use app\modules\base\models\WorkUser;
/**
 * WorkOddSearch represents the model behind the search form about `app\modules\base\models\WorkOdd`.
 */
class WorkOddSearch extends WorkOdd {
    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'oddBorrowPeriod', 'isCr', 'receiptStatus', 'finishType'], 'integer'],
            [['oddNumber', 'oddType', 'oddTitle', 'oddRepaymentStyle', 'oddTrialTime', 'oddRehearTime', 'userId', 'operator', 'receiptUserId', 'finishTime','nickName'], 'safe'],
            [['oddYearRate', 'oddMoney', 'serviceFee', 'offlineMoney', 'offlineRate'], 'number'],
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
    public function search($params) {
        $query = WorkOdd::find()
                ->select('a.*,b.nickName')
                ->from(WorkOdd::tableName().' a')
                ->leftJoin(WorkUser::tableName().' b','a.userId = b.strUserId');

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
            'a.id' => $this->id,
            'a.oddYearRate' => $this->oddYearRate,
            'a.oddMoney' => $this->oddMoney,
            'a.oddBorrowPeriod' => $this->oddBorrowPeriod,
            'a.serviceFee' => $this->serviceFee,
            'a.oddTrialTime' => $this->oddTrialTime,
            'a.oddRehearTime' => $this->oddRehearTime,
            'a.offlineMoney' => $this->offlineMoney,
            'a.offlineRate' => $this->offlineRate,
            'a.isCr' => $this->isCr,
            'a.receiptStatus' => $this->receiptStatus,
            'a.finishType' => $this->finishType,
            'a.finishTime' => $this->finishTime,
        ]);

        $query->andFilterWhere(['like', 'a.oddNumber', $this->oddNumber])
                ->andFilterWhere(['like', 'a.oddType', $this->oddType])
                ->andFilterWhere(['like', 'a.oddTitle', $this->oddTitle])
                ->andFilterWhere(['like', 'a.oddRepaymentStyle', $this->oddRepaymentStyle])
                ->andFilterWhere(['like', 'a.userId', $this->userId])
                ->andFilterWhere(['like', 'a.operator', $this->operator])
                ->andFilterWhere(['like', 'a.receiptUserId', $this->receiptUserId])
                ->andFilterWhere(['like', 'b.nickName', $this->nickName]);

        return $dataProvider;
    }

}
