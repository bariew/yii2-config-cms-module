<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 8/28/14
 * Time: 6:03 PM
 */

namespace bariew\configModule\components;

use app\config\FileModel;
use yii\base\Model;
use Yii;
use yii\helpers\FileHelper;

class Config extends Model
{
    protected static $key;

    protected $serializedAttributes = [];

    public function init()
    {
        parent::init();
        foreach ($this->getConfig()->get(self::getKey()) as $attribute => $value) {
            if (!$this->hasProperty($attribute)) {
                continue;
            }
            if (is_array($value)) {
                $this->serializedAttributes[] = $attribute;
                $value = json_encode($value);
            }
            $this->$attribute = $value;
        }
    }

    public function classValidation($attribute)
    {
        $class = $this->$attribute;
        if (!class_exists($class)) {
            $this->addError($attribute, Yii::t('modules/config', 'Class not found'));
        }
    }

    public function jsonValidation($attribute)
    {
        $data = json_decode($this->$attribute);
        if (!is_array($data) || json_last_error()) {
            $this->addError($attribute, json_last_error_msg());
        }
    }

    public function decodeJsonAttributes()
    {
        foreach ($this->serializedAttributes as $attribute) {
            $this->$attribute = json_decode($this->$attribute, true);
        }
    }

    public function encodeJsonAttributes()
    {
        foreach ($this->serializedAttributes as $attribute) {
            $this->$attribute = json_encode($this->$attribute);
        }
    }

    public function getIsSerializable($attribute)
    {
        return in_array($attribute, $this->serializedAttributes);
    }

    public function beforeSave()
    {
        $this->decodeJsonAttributes();
        return true;
    }

    public static function getKey()
    {
        if (static::$key !== null) {
            return static::$key;
        }
        $keys = explode('\\', static::getName());
        array_walk($keys, function (&$v) {$v = lcfirst($v);});
        return $keys;
    }

    public static function listAll()
    {
        $result = [];
        $modelPath = Yii::$app->getModule('config')->basePath . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;
        foreach (FileHelper::findFiles($modelPath) as $path) {
            $item = str_replace([$modelPath, '.php', '/'], ['', '', '\\'], $path);
            $result[$item] = $item;
        }
        return $result;
    }

    public static function getName()
    {
        return str_replace(self::getBaseModelNamespace().'\\', '', get_called_class());
    }

    public static function getBaseModelNamespace()
    {
        return preg_replace('/components$/', 'models', __NAMESPACE__);
    }

    public static function getClass($name)
    {
        return self::getBaseModelNamespace(). '\\' . $name;
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }
        if (!$this->beforeSave()) {
            $this->encodeJsonAttributes();
            return false;
        }
        if ($result = $this->getConfig()->set(self::getKey(), $this->attributes)) {
            $this->afterSave();
        };
        $this->encodeJsonAttributes();
        return $result;
    }

    public function afterSave(){}

    protected function getConfig()
    {
        return new \bariew\phptools\FileModel(Yii::getAlias('@app/config/web.php'), [
            'writePath' => Yii::getAlias('@app/config/local/main.php')
        ]);
    }
} 