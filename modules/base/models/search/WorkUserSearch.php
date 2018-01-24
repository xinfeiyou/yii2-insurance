<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkUser;

/**
 * WorkUserSearch represents the model behind the search form about `app\modules\base\models\WorkUser`.
 */
class WorkUserSearch extends WorkUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['strUserId', 'strPhone', 'strPass', 'nickName', 'gender', 'language', 'city', 'province', 'country', 'openId', 'avatarUrl', 'tCreateTime', 'tUpdateTime'], 'safe'],
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
        $query = WorkUser::find();

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
            ->andFilterWhere(['like', 'strPhone', $this->strPhone])
            ->andFilterWhere(['like', 'strPass', $this->strPass])
            ->andFilterWhere(['like', 'nickName', $this->nickName])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'openId', $this->openId])
            ->andFilterWhere(['like', 'avatarUrl', $this->avatarUrl]);

        return $dataProvider;
    }
}
