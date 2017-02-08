<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.02.2017
 * Time: 12:14
 */

namespace app\models;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

}