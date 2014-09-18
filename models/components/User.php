<?php

namespace bariew\configModule\models\components;

use bariew\configModule\components\Config;
use Yii;

class User extends Config
{
    public $class = 'yii\web\User';
    /**
     * @var string the class name of the [[identity]] object.
     */
    public $identityClass;
    /**
     * @var boolean whether to enable cookie-based login. Defaults to false.
     * Note that this property will be ignored if [[enableSession]] is false.
     */
    public $enableAutoLogin = 0;
    /**
     * @var boolean whether to use session to persist authentication status across multiple requests.
     * You set this property to be false if your application is stateless, which is often the case
     * for RESTful APIs.
     */
    public $enableSession = 1;
    /**
     * @var integer the number of seconds in which the user will be logged out automatically if he
     * remains inactive. If this property is not set, the user will be logged out after
     * the current session expires (c.f. [[Session::timeout]]).
     * Note that this will not work if [[enableAutoLogin]] is true.
     */
    public $authTimeout;
    /**
     * @var integer the number of seconds in which the user will be logged out automatically
     * regardless of activity.
     * Note that this will not work if [[enableAutoLogin]] is true.
     */
    public $absoluteAuthTimeout;
    /**
     * @var boolean whether to automatically renew the identity cookie each time a page is requested.
     * This property is effective only when [[enableAutoLogin]] is true.
     * When this is false, the identity cookie will expire after the specified duration since the user
     * is initially logged in. When this is true, the identity cookie will expire after the specified duration
     * since the user visits the site the last time.
     * @see enableAutoLogin
     */
    public $autoRenewCookie = 1;
    /**
     * @var string the session variable name used to store the value of [[id]].
     */
    public $idParam = '__id';
    /**
     * @var string the session variable name used to store the value of expiration timestamp of the authenticated state.
     * This is used when [[authTimeout]] is set.
     */
    public $authTimeoutParam = '__expire';
    /**
     * @var string the session variable name used to store the value of absolute expiration timestamp of the authenticated state.
     * This is used when [[absoluteAuthTimeout]] is set.
     */
    public $absoluteAuthTimeoutParam = '__absolute_expire';
    /**
     * @var string the session variable name used to store the value of [[returnUrl]].
     */
    public $returnUrlParam = '__returnUrl';


    public function rules()
    {
        return [
            [['class', 'identityClass'], 'required'],
            [['class', 'identityClass'], 'classValidation'],
            [['enableAutoLogin', 'enableSession', 'autoRenewCookie'], 'in', 'range' => [0,1]],
            [['authTimeout', 'absoluteAuthTimeout'], 'integer'],
            [['authTimeout', 'absoluteAuthTimeout'], 'default', 'value' => null],
            [['authTimeoutParam', 'absoluteAuthTimeoutParam', 'returnUrlParam'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'class' => Yii::t('modules/config', 'Class'),
            'identityClass' => Yii::t('modules/config', 'Identity class'),
            'enableAutoLogin' => Yii::t('modules/config', 'Enable auto login'),
            'enableSession' => Yii::t('modules/config', 'Enable session'),
            'autoRenewCookie' => Yii::t('modules/config', 'Auto renew cookie'),
            'authTimeout' => Yii::t('modules/config', 'Auth timeout'),
            'absoluteAuthTimeout' => Yii::t('modules/config', 'Absolute auth timeout'),
            'authTimeoutParam' => Yii::t('modules/config', 'Auth timeout param'),
            'absoluteAuthTimeoutParam' => Yii::t('modules/config', 'Absolute auth timeout param'),
        ];
    }
}
