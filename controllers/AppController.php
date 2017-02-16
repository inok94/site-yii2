<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08.02.2017
 * Time: 17:59
 */

namespace app\controllers;
use yii\web\Controller;

/**
 * Class AppController - общий контроллер 
 * @package app\controllers
 */
class AppController extends Controller
{
    /**
     * @param null $title
     * @param null $keywords
     * @param null $description
     */
    protected  function setMeta($title = null, $keywords = null, $description = null)
    {
        $this->view->title = $title;
        $this->view->registerMetaTag(['name' => 'keywords', 'content'=> "$keywords"]);
        $this->view->registerMetaTag(['name' => 'description', 'content'=> "$description"]);
    }

}