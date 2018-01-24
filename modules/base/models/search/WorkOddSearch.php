<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkOdd;

/**
 * WorkOddSearch represents the model behind the search form about `app\modules\work\models\WorkOdd`.
 */
class WorkOddSearch extends WorkOdd
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'oddBorrowPeriod', 'oddBorrowValidTime', 'lookstatus', 'investType', 'readstatus', 'cerStatus', 'fronStatus', 'isCr', 'receiptStatus', 'isATBiding', 'finishType'], 'integer'],
            [['oddNumber', 'oddType', 'oddTitle', 'oddBorrowStyle', 'oddRepaymentStyle', 'oddTrialTime', 'oddTrialRemark', 'oddRehearTime', 'oddRehearRemark', 'addtime', 'publishTime', 'fullTime', 'userId', 'progress', 'operator', 'openTime', 'appointUserId', 'oddStyle', 'firstFigure', 'receiptUserId', 'finishTime'], 'safe'],
            [['oddYearRate', 'oddMoney', 'successMoney', 'startMoney', 'endMoney', 'serviceFee', 'oddReward', 'offlineRate'], 'number'],
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
            'successMoney' => $this->successMoney,
            'startMoney' => $this->startMoney,
            'endMoney' => $this->endMoney,
            'oddBorrowPeriod' => $this->oddBorrowPeriod,
            'oddBorrowValidTime' => $this->oddBorrowValidTime,
            'serviceFee' => $this->serviceFee,
            'oddTrialTime' => $this->oddTrialTime,
            'oddRehearTime' => $this->oddRehearTime,
            'addtime' => $this->addtime,
            'publishTime' => $this->publishTime,
            'fullTime' => $this->fullTime,
            'lookstatus' => $this->lookstatus,
            'investType' => $this->investType,
            'readstatus' => $this->readstatus,
            'openTime' => $this->openTime,
            'oddReward' => $this->oddReward,
            'offlineRate' => $this->offlineRate,
            'cerStatus' => $this->cerStatus,
            'fronStatus' => $this->fronStatus,
            'isCr' => $this->isCr,
            'receiptStatus' => $this->receiptStatus,
            'isATBiding' => $this->isATBiding,
            'finishType' => $this->finishType,
            'finishTime' => $this->finishTime,
        ]);

        $query->andFilterWhere(['like', 'oddNumber', $this->oddNumber])
            ->andFilterWhere(['like', 'oddType', $this->oddType])
            ->andFilterWhere(['like', 'oddTitle', $this->oddTitle])
            ->andFilterWhere(['like', 'oddBorrowStyle', $this->oddBorrowStyle])
            ->andFilterWhere(['like', 'oddRepaymentStyle', $this->oddRepaymentStyle])
            ->andFilterWhere(['like', 'oddTrialRemark', $this->oddTrialRemark])
            ->andFilterWhere(['like', 'oddRehearRemark', $this->oddRehearRemark])
            ->andFilterWhere(['like', 'userId', $this->userId])
            ->andFilterWhere(['like', 'progress', $this->progress])
            ->andFilterWhere(['like', 'operator', $this->operator])
            ->andFilterWhere(['like', 'appointUserId', $this->appointUserId])
            ->andFilterWhere(['like', 'oddStyle', $this->oddStyle])
            ->andFilterWhere(['like', 'firstFigure', $this->firstFigure])
            ->andFilterWhere(['like', 'receiptUserId', $this->receiptUserId]);

        return $dataProvider;
    }
}
