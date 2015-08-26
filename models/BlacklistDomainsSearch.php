<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BlacklistDomains;

/**
 * BlacklistDomainsSearch represents the model behind the search form about `app\models\BlacklistDomains`.
 */
class BlacklistDomainsSearch extends BlacklistDomains
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'blacklist_id'], 'integer'],
            [['domain'], 'safe'],
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
    public function search($params,$blist_id)
    {
        $query = BlacklistDomains::find()->where(['blacklist_id'=>$blist_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
//             'id' => $this->id,
//             'blacklist_id' => $this->blacklist_id,
        ]);

        $query->andFilterWhere(['like', 'domain', $this->domain]);

        return $dataProvider;
    }
}
