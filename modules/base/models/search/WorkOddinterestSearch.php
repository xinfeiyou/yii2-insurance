<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkOddinterest;

/**
 * WorkOddinterestSearch represents the model behind the search form about `app\modules\work\models\WorkOddinterest`.
 */
class WorkOddinterestSearch extends WorkOddinterest {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'intPeriod', 'strPaymentStatus'], 'integer'],
            [['oddNumber', 'strUserId', 'tStartTime', 'tEndTime', 'tOperateTime'], 'safe'],
            [['fOnLineCost', 'fOnLineInterest', 'fOnLineTotal', 'fRemainder', 'fOffLineCost', 'fOffLineInterest', 'fSubsidy','fOffLineTotal','fRealMonery','fRealinterest'], 'number'],
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
        $query = WorkOddinterest::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 15,],
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
            'intPeriod' => $this->intPeriod,
            'fOnLineCost' => $this->fOnLineCost,
            'fOnLineInterest' => $this->fOnLineInterest,
            'fOnLineTotal' => $this->fOnLineTotal,
            'fRemainder' => $this->fRemainder,
            'fRealMonery' => $this->fRealMonery,
            'fRealinterest' => $this->fRealinterest,
            'fOffLineCost' => $this->fOffLineCost,
            'tStartTime' => $this->tStartTime,
            'tEndTime' => $this->tEndTime,
            'tOperateTime' => $this->tOperateTime,
            'strPaymentStatus' => $this->strPaymentStatus,
            'fSubsidy' => $this->fSubsidy,
            'fOffLineTotal' => $this->fOffLineTotal,
        ]);

        $query->andFilterWhere(['like', 'oddNumber', $this->oddNumber])
                ->andFilterWhere(['like', 'strUserId', $this->strUserId]);

        return $dataProvider;
    }

}
