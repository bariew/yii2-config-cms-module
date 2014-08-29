<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 8/28/14
 * Time: 6:03 PM
 */

namespace bariew\configModule\components;

use yii\base\Model;
use Yii;
use yii\helpers\FileHelper;

class Config extends Model
{
    protected static $localConfigPath = '@app/config/local/main.php';
    protected static $mainConfigPath = '@app/config/web.php';

    protected static $key;

    public function init()
    {
        parent::init();
        foreach (self::getMyConfig() as $attribute => $value) {
            if (!$this->hasProperty($attribute) || is_array($value)) {
                continue;
            }
            $this->$attribute = $value;
        }
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

    protected static function getMainConfig()
    {
        $path = Yii::getAlias(self::$mainConfigPath);
        return file_exists($path) ? require $path : [];
    }

    protected static function getLocalConfig()
    {
        $path = Yii::getAlias(self::$localConfigPath);
        return file_exists($path) ? require $path : [];
    }

    public function save()
    {
        if (!$this->validate() || !$this->beforeSave()) {
            return false;
        }
        $content = '<?php return '. var_export($this->setMyConfig(), true) . ';';
        $result = file_put_contents(\Yii::getAlias(self::$localConfigPath), $content);
        $this->afterSave();
        return $result;
    }

    public function beforeSave() { return true;}
    public function afterSave() {}

    public function delete()
    {
        $content = '<?php return '. var_export($this->removeMyConfig(), true) . ';';
        return file_put_contents(\Yii::getAlias(self::$localConfigPath), $content);
    }

    public function setMyConfig()
    {
        $key = self::getKey();
        $config = self::getLocalConfig();
        $data = &$config;
        if (!$key) {
            $config = array_merge($config, $this->attributes);
        }
        while ($key) {
            $k = array_shift($key);
            $config[$k] = isset($config[$k]) ? $config[$k] : [];
            $config[$k] = $key ? $config[$k] : array_merge($config[$k], $this->attributes);
            $config = &$config[$k];
        }
        return $data;
    }

    public static function getMyConfig()
    {
        $key = self::getKey();
        $config = self::getMainConfig();
        while ($key) {
            $k = array_shift($key);
            $config = isset($config[$k]) ? $config[$k] : [];
        }
        return $config;
    }


    public function removeMyConfig()
    {
        $key = self::getKey();
        $config = self::getLocalConfig();
        $data = &$config;
        if (!$key) {
            foreach ($this->attributes as $attribute => $value) {
                unset($config[$attribute]);
            }
        }
        while ($key) {
            $k = array_shift($key);
            if (!$key) {
                unset($config[$k]);
                break;
            }
            $config[$k] = isset($config[$k]) ? $config[$k] : [];
            $config = &$config[$k];
        }
        return $data;
    }
} 