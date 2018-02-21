<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkUserWithhold;

/**
 * WorkUserWithholdSearch represents the model behind the search form about `app\modules\base\models\WorkUserWithhold`.
 */
class WorkUserWithholdSearch extends WorkUserWithhold
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['strUserId', 'strBankName', 'strBankCode', 'strBankNum', 'strUserCode', 'strRealName', 'strUserPhone', 'tCreateTime', 'tUpdateTime'], 'safe'],
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
        $query = WorkUserWithhold::find();

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
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'strUserId', $this->strUserId])
            ->andFilterWhere(['like', 'strBankName', $this->strBankName])
            ->andFilterWhere(['like', 'strBankCode', $this->strBankCode])
            ->andFilterWhere(['like', 'strBankNum', $this->strBankNum])
            ->andFilterWhere(['like', 'strUserCode', $this->strUserCode])
            ->andFilterWhere(['like', 'strRealName', $this->strRealName])
            ->andFilterWhere(['like', 'strUserPhone', $this->strUserPhone]);

        return $dataProvider;
    }
}
