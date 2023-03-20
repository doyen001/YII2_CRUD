<?php

namespace app\controllers;

use Yii;

use yii\data\Pagination;
use yii\rest\ActiveController;
use yii\web\Response;
use app\models\Fruit;

class FruitController extends \yii\rest\Controller
{    
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
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
            'rows' => $models,
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
            $email = Yii::$app->mailer->compose()
                    ->setFrom('test@gmail.com')
                    ->setTo('test@gmail.com')
                    ->setSubject('New Fruit Added')
                    ->setTextBody('A new fruit has been added: ')
                    ->setHtmlBody('<b>HTML</b> content of the email')
                    ->send();
            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;
            $response->setStatusCode(201);
            $response->data = ['status' => true, 'message' => 'Fruit created successfully'];
            return $response;
        } else {
            $response = Yii::$app->getResponse();
            $response->format = Response::FORMAT_JSON;
            $response->setStatusCode(500);
            $response->data = ['status' => false, 'message' => 'Failed to create fruit', 'errors' => $model->errors];
            
            return $response;
        }
    }

}
