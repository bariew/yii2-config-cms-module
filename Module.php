<?php

namespace bariew\configModule;

class Module extends \yii\base\Module
{
    public $params =  [
        'menu'  => [
            'label'    => 'Settings',
            'items' => [
                ['label' => 'App config', 'url' => ['/config/item/update', 'name' => 'Main']]
            ]
        ]
    ];
}
