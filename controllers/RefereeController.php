<?php

namespace app\controllers;

use Yii;
use app\models\Referee;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class RefereeController extends Controller
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
        $model = new Referee();
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Referee added successfully!');
                return $this->redirect(['/user/profile-edit#referees']);
            } else {
                // Debug validation errors if needed
                Yii::error('Referee validation failed: ' . print_r($model->errors, true));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('@app/views/JobPortal/System/User/referee/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Referee updated successfully!');
            return $this->redirect(['/user/profile-edit#referees']);
        }

        return $this->render('@app/views/JobPortal/System/User/referee/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Referee deleted successfully!');

        return $this->redirect(['/user/profile-edit#referees']);
    }

    protected function findModel($id)
    {
        if (($model = Referee::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}