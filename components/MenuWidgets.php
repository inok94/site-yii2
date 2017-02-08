<?php

namespace  app\components;
use yii\base\Widget;
use app\models\Category;
use Yii;

class MenuWidgets extends Widget
{
    /**
     * @var
     */
    public $tpl;
    public $data;//массив категорий из бд
    public $tree;//постройка массив дерева категорий
    public $menuHtml; // готовый шаблон который сохраниться в tpl
    // проверка какой шаблон будет использовать виджет
    // select || <ul>
    public function init()
    {
        parent::init();
        if ($this->tpl === null)
        {
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }

    /**
     * @return mixed
     * @var $tree
     */
    public function run()
    {
        //get cache
        $menu =\Yii::$app->cache->get('menu');
        if ($menu) return $menu;

        $this->data = Category::find()->indexBy('id')->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        //debug($this->tree);
        //Set cache
        Yii::$app->cache->set('menu', $this->menuHtml, 30);
        return $this->menuHtml;
    }
    //получаем древовидный массив
    /**
     * @return array
     */
    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id=> &$node)
        {
            if (!$node['parent_id'])
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }

    /**
     * @param $tree
     *
     * @return string
     */
    protected function getMenuHtml($tree)
    {
        $src ='';
        foreach ($tree as $category) 
        {
            $src .= $this->catToTemplate($category);
        }
        return $src;
    }

    /**
     * @param $category
     *
     * @return string
     */
    protected function catToTemplate($category)
    {
        /**
         * Включение буферизации вывода
         * http://php.net/manual/ru/function.ob-start.php
         */
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}