<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class View extends Config
{
    public $class = 'yii\web\View';
    /**
     * @var array a list of available renderers indexed by their corresponding supported file extensions.
     * Each renderer may be a view renderer object or the configuration for creating the renderer object.
     * For example, the following configuration enables both Smarty and Twig view renderers:
     *
     * ~~~
     * [
     *     'tpl' => ['class' => 'yii\smarty\ViewRenderer'],
     *     'twig' => ['class' => 'yii\twig\ViewRenderer'],
     * ]
     * ~~~
     *
     * If no renderer is available for the given view file, the view file will be treated as a normal PHP
     * and rendered via [[renderPhpFile()]].
     */
    public $renderers;
    /**
     * @var string the default view file extension. This will be appended to view file names if they don't have file extensions.
     */
    public $defaultExtension = 'php';
    /**
     * @var Theme|array|string the theme object or the configuration for creating the theme object.
     * If not set, it means theming is not enabled.
     */
    public $theme;


    public function rules()
    {
        return [
            [['class', 'defaultExtension'], 'required'],
            [['class'], 'classValidation'],
            [['renderers'], 'default', 'value' => null],
            [['defaultExtension'], 'string'],
            [['theme', 'renderers'], 'jsonValidation'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'renderers' => Yii::t('modules/config', 'Renderers'),
            'defaultExtension' => Yii::t('modules/config', 'Default extension'),
            'theme' => Yii::t('modules/config', 'Theme'),
        ];
    }
}
