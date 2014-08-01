<?php

namespace bariew\configModule\models;

use Yii;
use yii\base\Model;
use yii\db\Connection;

class Local extends Model
{
    public $id;
    public $language;
    public $components;
    public $params;

    protected static $configPath = '@app/config/local/main.php';

    public function rules()
    {
        return [
            [['id', 'language'], 'required'],
            [['id', 'language'], 'string'],

            [['components', 'params'], 'safe']

        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    => 'Application name',
        ];
    }

    public function init()
    {
        parent::init();
        $this->attributes = self::getConfig();
    }

    public static function getConfig()
    {
        $path = Yii::getAlias(self::$configPath);
        return file_exists($path) ? require($path) : [];
    }

    public function save($models = [])
    {
        if (!$this->attachSubModels($models, $this) || !$this->validate()) {
            return false;
        }
        $content = '<?php return '. var_export($this->attributes, true) . ';';
        file_put_contents(Yii::getAlias(self::$configPath), $content);
        return true;
    }

    protected function attachSubModels($models, &$owner)
    {
        $validated = true;
        foreach ($models as $key => $model) {
            if (!is_array($model)) {
                $validated = $model->validate() ? $validated : false;
                $owner[$key] = is_array($owner[$key])
                    ? array_merge($owner[$key], $model->attributes) : $model->attributes;
            } else {
                $newData = $owner[$key];
                $validated = $this->attachSubModels($model, $newData)
                    ? $validated : false;
                $owner[$key] = $newData;
            }
        }
        return $validated;
    }

    public static function validateConfig()
    {
        $config = self::getConfig();
        return ComponentsDb::validateConfig(
            isset($config['components']['db']) ? $config['components']['db'] : []
        );
    }
}
