<?php

namespace app\controllers;

use Yii;
use app\models\ProfessionalQualification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ProfessionalQualificationController extends Controller
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
        $model = new ProfessionalQualification();
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Professional certification added successfully!');
                return $this->redirect(['/user/profile-edit#certificates']);
            } else {
                // Debug validation errors if needed
                Yii::error('ProfessionalQualification validation failed: ' . print_r($model->errors, true));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('@app/views/JobPortal/System/User/professional-qualification/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Professional certification updated successfully!');
            return $this->redirect(['/user/profile-edit#certificates']);
        }

        return $this->render('@app/views/JobPortal/System/User/professional-qualification/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Professional certification deleted successfully!');

        return $this->redirect(['/user/profile-edit#certificates']);
    }

    protected function findModel($id)
    {
        if (($model = ProfessionalQualification::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}