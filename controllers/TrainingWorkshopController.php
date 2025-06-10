<?php

namespace app\controllers;

use Yii;
use app\models\TrainingWorkshop;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class TrainingWorkshopController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new TrainingWorkshop();
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Training/Workshop added successfully!');
                return $this->redirect(['/user/profile-edit#training']);
            } else {
                // Debug validation errors if needed
                Yii::error('TrainingWorkshop validation failed: ' . print_r($model->errors, true));
            }
        } else {
            $model->loadDefaultValues();
        }

        // Use the correct view path - point to the JobPortal structure
        return $this->render('@app/views/JobPortal/System/User/training-workshop/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Training/Workshop updated successfully!');
            return $this->redirect(['/user/profile-edit#training']);
        }

        return $this->render('@app/views/JobPortal/System/User/training-workshop/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Training/Workshop deleted successfully!');

        return $this->redirect(['/user/profile-edit#training']);
    }

    protected function findModel($id)
    {
        if (($model = TrainingWorkshop::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}