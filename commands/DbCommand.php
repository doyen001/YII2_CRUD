<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class DbCommand extends Controller
{
    public function actionSeed()
    {
        // Fetch data from the API
        $url = 'https://fruityvice.com/api/fruit/all';
        $data = file_get_contents($url);
        $fruits = json_decode($data, true);

        // Save data to the database
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand();
        foreach ($fruits as $fruit) {
            $command->insert('fruits', [
                'genus' => $fruit['genus'],
                'name' => $fruit['name'],
                'family' => $fruit['family'],
                'order' => $fruit['order'],
                'n_carbohydrates' => $fruit['nutritions']['carbohydrates'],
                'n_protein' => $fruit['nutritions']['protein'],
                'n_fat' => $fruit['nutritions']['fat'],
                'n_calories' => $fruit['nutritions']['calories'],
                'n_sugar' => $fruit['nutritions']['sugar']
            ])->execute();
        }
        echo "Data has been seeded to the database.\n";
    }
}
?>