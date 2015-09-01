<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CacheForm extends Model
{
    public $patterns;
    public $options;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        	[['patterns', 'options'], 'safe']
        ];
    }
}