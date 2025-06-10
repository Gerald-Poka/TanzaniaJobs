<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\Pagination;
use app\models\JobApplication;
use app\models\Job;

class UserApplicationsController extends Controller
{
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
                        'actions' => ['active', 'pending', 'interviews', 'history', 'withdraw'],
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
        ];
    }

    /**
     * Active applications (pending, reviewing, shortlisted, interviewed)
     */
    public function actionActive()
    {
        $userId = Yii::$app->user->id;
        
        $query = JobApplication::find()
            ->alias('ja')
            ->select([
                'ja.*', 'j.title as job_title', 'j.company_id', 'j.location',
                'j.job_type', 'j.salary_min', 'j.salary_max', 'j.salary_currency',
                'c.name as company_name', 'c.logo as company_logo', 'c.verified as company_verified'
            ])
            ->innerJoin(['j' => 'jobs'], 'ja.job_id = j.id')
            ->leftJoin(['c' => 'companies'], 'j.company_id = c.id')
            ->where(['ja.applicant_id' => $userId])
            ->andWhere(['in', 'ja.status', [
                JobApplication::STATUS_PENDING,
                JobApplication::STATUS_REVIEWING,
                JobApplication::STATUS_SHORTLISTED,
                JobApplication::STATUS_INTERVIEWED
            ]])
            ->orderBy(['ja.applied_at' => SORT_DESC]);
            
        $count = $query->count();
        
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 10,
        ]);
        
        $applications = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray() // Add this line to convert models to arrays
            ->all();
            
        return $this->render('@app/views/JobPortal/System/User/applications/active', [
            'applications' => $applications,
            'pagination' => $pagination,
            'title' => 'Active Applications',
            'pageTitle' => 'My Active Job Applications',
        ]);
    }
    
    /**
     * Pending applications
     */
    public function actionPending()
    {
        $userId = Yii::$app->user->id;
        
        $query = JobApplication::find()
            ->alias('ja')
            ->select([
                'ja.*', 'j.title as job_title', 'j.company_id', 'j.location',
                'j.job_type', 'j.salary_min', 'j.salary_max', 'j.salary_currency',
                'c.name as company_name', 'c.logo as company_logo', 'c.verified as company_verified'
            ])
            ->innerJoin(['j' => 'jobs'], 'ja.job_id = j.id')
            ->leftJoin(['c' => 'companies'], 'j.company_id = c.id')
            ->where(['ja.applicant_id' => $userId])
            ->andWhere(['ja.status' => JobApplication::STATUS_PENDING])
            ->orderBy(['ja.applied_at' => SORT_DESC]);
            
        $count = $query->count();
        
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 10,
        ]);
        
        $applications = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray() // Add this line
            ->all();
            
        return $this->render('@app/views/JobPortal/System/User/applications/pending', [
            'applications' => $applications,
            'pagination' => $pagination,
            'title' => 'Pending Applications',
            'pageTitle' => 'My Pending Job Applications',
        ]);
    }
    
    /**
     * Interview applications
     */
    public function actionInterviews()
    {
        $userId = Yii::$app->user->id;
        
        $query = JobApplication::find()
            ->alias('ja')
            ->select([
                'ja.*', 'j.title as job_title', 'j.company_id', 'j.location',
                'j.job_type', 'j.salary_min', 'j.salary_max', 'j.salary_currency',
                'c.name as company_name', 'c.logo as company_logo', 'c.verified as company_verified'
            ])
            ->innerJoin(['j' => 'jobs'], 'ja.job_id = j.id')
            ->leftJoin(['c' => 'companies'], 'j.company_id = c.id')
            ->where(['ja.applicant_id' => $userId])
            ->andWhere(['ja.status' => JobApplication::STATUS_INTERVIEWED])
            ->orderBy(['ja.applied_at' => SORT_DESC]);
            
        $count = $query->count();
        
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 10,
        ]);
        
        $applications = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray() // Add this line
            ->all();
            
        return $this->render('@app/views/JobPortal/System/User/applications/interviews', [
            'applications' => $applications,
            'pagination' => $pagination,
            'title' => 'Interview Schedule',
            'pageTitle' => 'My Interview Schedule',
        ]);
    }
    
    /**
     * Application history (accepted, rejected, withdrawn)
     */
    public function actionHistory()
    {
        $userId = Yii::$app->user->id;
        
        $query = JobApplication::find()
            ->alias('ja')
            ->select([
                'ja.*', 'j.title as job_title', 'j.company_id', 'j.location',
                'j.job_type', 'j.salary_min', 'j.salary_max', 'j.salary_currency',
                'c.name as company_name', 'c.logo as company_logo', 'c.verified as company_verified'
            ])
            ->innerJoin(['j' => 'jobs'], 'ja.job_id = j.id')
            ->leftJoin(['c' => 'companies'], 'j.company_id = c.id')
            ->where(['ja.applicant_id' => $userId])
            ->andWhere(['in', 'ja.status', [
                JobApplication::STATUS_ACCEPTED,
                JobApplication::STATUS_REJECTED,
                JobApplication::STATUS_WITHDRAWN
            ]])
            ->orderBy(['ja.applied_at' => SORT_DESC]);
            
        $count = $query->count();
        
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => 10,
        ]);
        
        $applications = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray() // Add this line
            ->all();
            
        return $this->render('@app/views/JobPortal/System/User/applications/history', [
            'applications' => $applications,
            'pagination' => $pagination,
            'title' => 'Application History',
            'pageTitle' => 'My Application History',
        ]);
    }
    
    /**
     * Withdraw an application
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionWithdraw($id)
    {
        $userId = Yii::$app->user->id;
        $model = JobApplication::findOne([
            'id' => $id,
            'applicant_id' => $userId
        ]);
        
        if (!$model) {
            Yii::$app->session->setFlash('error', 'Application not found or you do not have permission to withdraw it.');
            return $this->redirect(['active']);
        }
        
        // Only allow withdrawing pending or reviewing applications
        if (!in_array($model->status, [JobApplication::STATUS_PENDING, JobApplication::STATUS_REVIEWING])) {
            Yii::$app->session->setFlash('error', 'You can only withdraw applications that are pending or under review.');
            return $this->redirect(['active']);
        }
        
        $model->status = JobApplication::STATUS_WITHDRAWN;
        
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Your application has been withdrawn successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to withdraw your application. Please try again.');
        }
        
        return $this->redirect(['active']);
    }
}