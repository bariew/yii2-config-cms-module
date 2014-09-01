<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 8/29/14
 * Time: 6:52 PM
 */

namespace bariew\configModule\widgets;


use bariew\configModule\components\Config;
use bariew\dropdown\Nav as MainNav;
use yii\helpers\Url;

class Menu extends MainNav
{
    public function init()
    {
        $this->generateItems();
        parent::init();
    }

    protected function generateItems()
    {
        foreach (Config::listAll() as $name) {
            $this->insertItem($name, true);
            $this->insertItem($this->getParentName($name), false);
        }
    }

    protected function insertItem($name, $force = false)
    {
        $id = strtolower($name);
        if (!$id || (isset($this->items[$id]) && !$force)) {
            return;
        }
        $this->items[$id] = [
            'id' => $id,
            'name' => preg_replace('/.*\\\\(\w+)$/', '$1', $name),
            'url'=> Url::toRoute(['/config/item/update', 'name' => $name]),
            'parent_id' => strtolower($this->getParentName($name)),
            'childrenTree' => []
        ];
    }
    protected function getParentName($name)
    {
        return preg_replace('/\\\\?\w+$/','', $name);
    }
}