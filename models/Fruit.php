<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fruits".
 *
 * @property int $id
 * @property string $genus
 * @property string $name
 * @property string $family
 * @property string $order
 * @property float $n_carbohydrates
 * @property float $n_protein
 * @property float $n_fat
 * @property int $n_calories
 * @property float $n_sugar
 */
class Fruit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fruits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['genus', 'name', 'family', 'order', 'n_carbohydrates', 'n_protein', 'n_fat', 'n_calories', 'n_sugar'], 'required'],
            [['n_carbohydrates', 'n_protein', 'n_fat', 'n_sugar'], 'number'],
            [['n_calories'], 'integer'],
            [['genus', 'name', 'family', 'order'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'genus' => 'Genus',
            'name' => 'Name',
            'family' => 'Family',
            'order' => 'Order',
            'n_carbohydrates' => 'N Carbohydrates',
            'n_protein' => 'N Protein',
            'n_fat' => 'N Fat',
            'n_calories' => 'N Calories',
            'n_sugar' => 'N Sugar',
        ];
    }
}
