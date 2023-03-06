<?php

namespace app\controllers;

use Yii;

use yii\data\Pagination;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Fruit;

class FruitController extends \yii\rest\Controller
{

    public function actions()
    {
        $actions = parent::actions();
        
        // disable the "index" and "view" actions
        unset($actions['index']);
        unset($actions['view']);
        
        return $actions;
    }
    
    public function actionIndex($name = null, $family = null)
    {
        $query = Fruit::find();

        if (!empty($name)) {
            $query->andWhere(['like', 'name', $name]);
        }

        if (!empty($family)) {
            $query->andWhere(['like', 'family', $family]);
        }

        $countQuery = clone $query;
        $pages = new Pagination([
            'defaultPageSize' => 40,
        ]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $response = Yii::$app->getResponse();
        $response->format = Response::FORMAT_JSON;
        $response->data = [
            'data' => $models,
            'pages' => $pages,
        ];

        return $response;
    }

    /**
     * Add new fruit
     */

     public function actionCreate()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $model = new Fruit();
        $model->attributes = $data;
        // Load attributes from request data
            if ($model->save()) {
                // send email notification
                $email = Yii::$app->mailer->compose()
                    ->setFrom('noreply@example.com')
                    ->setTo('admin@example.com')
                    ->setSubject('New Fruit Added')
                    ->setTextBody('A new fruit has been added: ' . $model->name)
                    ->send();

                return [
                    'success' => true,
                    'fruit' => $model->name,
                ];
            }
    }

}
