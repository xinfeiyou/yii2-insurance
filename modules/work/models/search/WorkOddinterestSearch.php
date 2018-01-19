<?php

namespace app\modules\work\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\work\models\WorkOddinterest;

/**
 * WorkOddinterestSearch represents the model behind the search form about `app\modules\work\models\WorkOddinterest`.
 */
class WorkOddinterestSearch extends WorkOddinterest {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'qishu', 'status'], 'integer'],
            [['oddNumber', 'userId', 'addtime', 'endtime', 'operatetime'], 'safe'],
            [['benJin', 'interest', 'zongEr', 'yuEr', 'realAmount', 'realinterest', 'subsidy'], 'number'],
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
            'qishu' => $this->qishu,
            'benJin' => $this->benJin,
            'interest' => $this->interest,
            'zongEr' => $this->zongEr,
            'yuEr' => $this->yuEr,
            'realAmount' => $this->realAmount,
            'realinterest' => $this->realinterest,
            'addtime' => $this->addtime,
            'endtime' => $this->endtime,
            'operatetime' => $this->operatetime,
            'status' => $this->status,
            'subsidy' => $this->subsidy,
        ]);

        $query->andFilterWhere(['like', 'oddNumber', $this->oddNumber])
                ->andFilterWhere(['like', 'userId', $this->userId]);

        return $dataProvider;
    }

}
