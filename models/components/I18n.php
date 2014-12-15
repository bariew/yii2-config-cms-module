<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class I18n extends Config
{
    public $class;
    /**
     * @var array list of [[MessageSource]] configurations or objects. The array keys are message
     * category patterns, and the array values are the corresponding [[MessageSource]] objects or the configurations
     * for creating the [[MessageSource]] objects.
     *
     * The message category patterns can contain the wildcard '*' at the end to match multiple categories with the same prefix.
     * For example, 'app/*' matches both 'app/cat1' and 'app/cat2'.
     *
     * The '*' category pattern will match all categories that do not match any other category patterns.
     *
     * This property may be modified on the fly by extensions who want to have their own message sources
     * registered under their own namespaces.
     *
     * The category "yii" and "app" are always defined. The former refers to the messages used in the Yii core
     * framework code, while the latter refers to the default message category for custom application code.
     * By default, both of these categories use [[PhpMessageSource]] and the corresponding message files are
     * stored under "@yii/messages" and "@app/messages", respectively.
     *
     * You may override the configuration of both categories.
     */
    public $translations;

    /**
     * @inheritdoc
     */
    protected $jsonAttributes = ['translations'];


    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class'], 'classValidation'],
            [['translations'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'translations' => Yii::t('modules/config', 'Translations'),
        ];
    }
}
