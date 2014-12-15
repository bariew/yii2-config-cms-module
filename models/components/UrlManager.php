<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class UrlManager extends Config
{
    public $class = 'yii\web\UrlManager';

    /**
     * @var boolean whether to enable pretty URLs. Instead of putting all parameters in the query
     * string part of a URL, pretty URLs allow using path info to represent some of the parameters
     * and can thus produce more user-friendly URLs, such as "/news/Yii-is-released", instead of
     * "/index.php?r=news/view&id=100".
     */
    public $enablePrettyUrl = false;

    /**
     * @var boolean whether to enable strict parsing. If strict parsing is enabled, the incoming
     * requested URL must match at least one of the [[rules]] in order to be treated as a valid request.
     * Otherwise, the path info part of the request will be treated as the requested route.
     * This property is used only when [[enablePrettyUrl]] is true.
     */
    public $enableStrictParsing = false;

    /**
     * @var array the rules for creating and parsing URLs when [[enablePrettyUrl]] is true.
     * This property is used only if [[enablePrettyUrl]] is true. Each element in the array
     * is the configuration array for creating a single URL rule. The configuration will
     * be merged with [[ruleConfig]] first before it is used for creating the rule object.
     *
     * A special shortcut format can be used if a rule only specifies [[UrlRule::pattern|pattern]]
     * and [[UrlRule::route|route]]: `'pattern' => 'route'`. That is, instead of using a configuration
     * array, one can use the key to represent the pattern and the value the corresponding route.
     * For example, `'post/<id:\d+>' => 'post/view'`.
     *
     * For RESTful routing the mentioned shortcut format also allows you to specify the
     * [[UrlRule::verb|HTTP verb]] that the rule should apply for.
     * You can do that  by prepending it to the pattern, separated by space.
     * For example, `'PUT post/<id:\d+>' => 'post/update'`.
     * You may specify multiple verbs by separating them with comma
     * like this: `'POST,PUT post/index' => 'post/create'`.
     * The supported verbs in the shortcut format are: GET, HEAD, POST, PUT, PATCH and DELETE.
     * Note that [[UrlRule::mode|mode]] will be set to PARSING_ONLY when specifying verb in this way
     * so you normally would not specify a verb for normal GET request.
     *
     * Here is an example configuration for RESTful CRUD controller:
     *
     * ~~~php
     * [
     *     'dashboard' => 'site/index',
     *
     *     'POST <controller:\w+>s' => '<controller>/create',
     *     '<controller:\w+>s' => '<controller>/index',
     *
     *     'PUT <controller:\w+>/<id:\d+>'    => '<controller>/update',
     *     'DELETE <controller:\w+>/<id:\d+>' => '<controller>/delete',
     *     '<controller:\w+>/<id:\d+>'        => '<controller>/view',
     * ];
     * ~~~
     *
     * Note that if you modify this property after the UrlManager object is created, make sure
     * you populate the array with rule objects instead of rule configurations.
     */
    public $rules = [];

    /**
     * @var string the URL suffix used when in 'path' format.
     * For example, ".html" can be used so that the URL looks like pointing to a static HTML page.
     * This property is used only if [[enablePrettyUrl]] is true.
     */
    public $suffix;

    /**
     * @var boolean whether to show entry script name in the constructed URL. Defaults to true.
     * This property is used only if [[enablePrettyUrl]] is true.
     */
    public $showScriptName = true;

    /**
     * @var string the GET parameter name for route. This property is used only if [[enablePrettyUrl]] is false.
     */
    public $routeParam = 'r';

    /**
     * @inheritdoc
     */
    protected $jsonAttributes = ['rules'];


    public function rules()
    {
        return [
            [['class'], 'required'],
            [['class'], 'classValidation'],
            [['enablePrettyUrl', 'enableStrictParsing', 'showScriptName'], 'in', 'range' => [0,1]],
            [['routeParam', 'suffix'], 'string'],
            [['rules'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'enablePrettyUrl' => Yii::t('modules/config', 'Enable pretty url'),
            'enableStrictParsing' => Yii::t('modules/config', 'Enable strict parsing'),
            'showScriptName' => Yii::t('modules/config', 'Show script name'),
            'routeParam' => Yii::t('modules/config', 'Route param'),
            'suffix' => Yii::t('modules/config', 'Suffix'),
            'rules' => Yii::t('modules/config', 'Rules'),
        ];
    }
}
