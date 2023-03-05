<?php
namespace app\models;

use Yii;
use app\events\NewFruitEvent;

class Fruit extends \yii\db\ActiveRecord
{
    // ...

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $event = new NewFruitEvent(['fruit' => $this]);
            Yii::$app->trigger('newFruit', $event);
        }

        parent::afterSave($insert, $changedAttributes);
    }

    // ...
}
?>