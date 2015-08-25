<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AnonymityForm extends Model
{
    public $users;
    public $anonymous_users;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        	[['users', 'anonymous_users'], 'safe']
        ];
    }
}