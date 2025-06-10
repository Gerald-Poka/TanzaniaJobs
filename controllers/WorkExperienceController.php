<?php

namespace app\controllers;

use Yii;
use app\models\WorkExperience;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class WorkExperienceController extends Controller
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
        $model = new WorkExperience();
        $model->user_id = Yii::$app->user->id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success', 'Work experience added successfully!');
                return $this->redirect(['/user/profile-edit#experience']);
            }
        } else {
            $model->loadDefaultValues();
        }

        // Use the correct view path
        return $this->render('@app/views/JobPortal/System/User/work-experience/create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Work experience updated successfully!');
            return $this->redirect(['/user/profile-edit#experience']);
        }

        // Use the correct view path
        return $this->render('@app/views/JobPortal/System/User/work-experience/update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Work experience deleted successfully!');

        return $this->redirect(['/user/profile-edit#experience']);
    }

    protected function findModel($id)
    {
        if (($model = WorkExperience::findOne(['id' => $id, 'user_id' => Yii::$app->user->id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}