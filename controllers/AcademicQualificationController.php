<?php

namespace app\controllers;

use Yii;
use app\models\AcademicQualification;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AcademicQualificationController implements the CRUD actions for AcademicQualification model.
 */
class AcademicQualificationController extends Controller
{
    /**
     * Set the view path to the custom location
     */
    public function init()
    {
        parent::init();
        $this->viewPath = '@app/views/JobPortal/System/User/academic-qualification';
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
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

    /**
     * Creates a new AcademicQualification model.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AcademicQualification();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Academic qualification added successfully.');
            return $this->redirect(['/user/profile-edit', '#' => 'education']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AcademicQualification model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        // Security check - only allow users to edit their own qualifications
        if ($model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('You are not authorized to edit this qualification.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Academic qualification updated successfully.');
            return $this->redirect(['/user/profile-edit', '#' => 'education']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an AcademicQualification model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        // Security check - only allow users to delete their own qualifications
        if ($model->user_id != Yii::$app->user->id) {
            throw new NotFoundHttpException('You are not authorized to delete this qualification.');
        }
        
        $model->delete();
        Yii::$app->session->setFlash('success', 'Academic qualification deleted successfully.');
        return $this->redirect(['/user/profile-edit', '#' => 'education']);
    }

    /**
     * Finds the AcademicQualification model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AcademicQualification the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AcademicQualification::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested qualification does not exist.');
    }
}