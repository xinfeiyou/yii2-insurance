<?php

namespace app\modules\base\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\base\models\WorkApply;

/**
 * WorkApplySearch represents the model behind the search form about `app\modules\base\models\WorkApply`.
 */
class WorkApplySearch extends WorkApply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['strWorkNum', 'strRealName', 'strPhone', 'strTravelAdder', 'strCarNumber', 'strCompulsoryInsurance', 'tCompulsoryInsuranceEffectiveTime', 'strCommercialInsurance', 'tCommercialInsuranceEffectiveTime', 'strLossInsurance', 'strThirdPartyInsurance', 'strTheftInsurance', 'strDriverLiabilityInsurance', 'strPassengerLiabilityInsurance', 'strGlassInsurance', 'strSelfIgnitionInsurance', 'strWadingInsurance', 'strScratchInsurance', 'strExcessInsurance', 'strInsuranceOffice', 'tCreateTime', 'tUpdateTime'], 'safe'],
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
        $query = WorkApply::find();

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
            'tCompulsoryInsuranceEffectiveTime' => $this->tCompulsoryInsuranceEffectiveTime,
            'tCommercialInsuranceEffectiveTime' => $this->tCommercialInsuranceEffectiveTime,
            'tCreateTime' => $this->tCreateTime,
            'tUpdateTime' => $this->tUpdateTime,
        ]);

        $query->andFilterWhere(['like', 'strWorkNum', $this->strWorkNum])
            ->andFilterWhere(['like', 'strRealName', $this->strRealName])
            ->andFilterWhere(['like', 'strPhone', $this->strPhone])
            ->andFilterWhere(['like', 'strTravelAdder', $this->strTravelAdder])
            ->andFilterWhere(['like', 'strCarNumber', $this->strCarNumber])
            ->andFilterWhere(['like', 'strCompulsoryInsurance', $this->strCompulsoryInsurance])
            ->andFilterWhere(['like', 'strCommercialInsurance', $this->strCommercialInsurance])
            ->andFilterWhere(['like', 'strLossInsurance', $this->strLossInsurance])
            ->andFilterWhere(['like', 'strThirdPartyInsurance', $this->strThirdPartyInsurance])
            ->andFilterWhere(['like', 'strTheftInsurance', $this->strTheftInsurance])
            ->andFilterWhere(['like', 'strDriverLiabilityInsurance', $this->strDriverLiabilityInsurance])
            ->andFilterWhere(['like', 'strPassengerLiabilityInsurance', $this->strPassengerLiabilityInsurance])
            ->andFilterWhere(['like', 'strGlassInsurance', $this->strGlassInsurance])
            ->andFilterWhere(['like', 'strSelfIgnitionInsurance', $this->strSelfIgnitionInsurance])
            ->andFilterWhere(['like', 'strWadingInsurance', $this->strWadingInsurance])
            ->andFilterWhere(['like', 'strScratchInsurance', $this->strScratchInsurance])
            ->andFilterWhere(['like', 'strExcessInsurance', $this->strExcessInsurance])
            ->andFilterWhere(['like', 'strInsuranceOffice', $this->strInsuranceOffice]);

        return $dataProvider;
    }
}
