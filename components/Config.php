<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 8/28/14
 * Time: 6:03 PM
 */

namespace bariew\configModule\components;


use bariew\configModule\models\Params;
use yii\base\Model;
use Yii;
use yii\helpers\FileHelper;

class Config extends Model
{
    protected static $localConfigPath = '@app/config/local/main.php';
    protected static $mainConfigPath = '@app/config/web.php';

    protected static $key = [];

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

    public function getName()
    {
        return str_replace('bariew\configModule\models\\', '', get_called_class());
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
        if (!$this->validate()) {
            return false;
        }
        $content = '<?php return '. var_export($this->setMyConfig(), true) . ';';
        return file_put_contents(\Yii::getAlias(self::$localConfigPath), $content);
    }

    public function setMyConfig()
    {
        $key = static::$key;
        $config = self::getLocalConfig();
        $data = &$config;
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
        $key = static::$key;
        $config = self::getMainConfig();
        while ($key) {
            $k = array_shift($key);
            $config = isset($config[$k]) ? $config[$k] : [];
        }
        return $config;
    }
} 