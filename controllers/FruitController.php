<?php

namespace app\controllers;

use Yii;

use yii\data\Pagination;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Fruit;

class FruitController extends \yii\rest\Controller
{    
    public static function allowedDomains() {
        return [
            '*',                        // star allows all domains
        ];
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['POST'],
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ],
            ],
        ];
    }

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
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

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

    public function actionCreate()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $model = new Fruit();
        $model->attributes = $data;

        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            // return ['status' => true, 'message' => 'Fruit created successfully'];
            return 'Fruit created successfully';
        } else {
            // return ['status' => false, 'message' => 'Failed to create fruit', 'errors' => $model->errors];
            $data = ['status' => false, 'message' => 'Failed to create fruit', 'errors' => $model->errors];
            $response = Yii::$app->response;
            $response->format = yii\web\Response::FORMAT_JSON;
            $response->data = $data;

            return $response;
        }
    }

}
