<?php

namespace bariew\configModule\models;

use Yii;
use yii\base\Model;

class Params extends Model
{
    public $adminEmail;

    public function rules()
    {
        return [
            [['adminEmail'], 'required'],
            [['adminEmail'], 'email'],
        ];
    }

    public function init()
    {
        $config = Local::getConfig();
        if (isset($config['params'])) {
            $this->attributes = $config['params'];
        }
    }
}
