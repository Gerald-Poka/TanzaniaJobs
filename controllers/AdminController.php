<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['admin-dashboard', 'manage-users'],
                        'allow' => true,
                        'roles' => ['@'], // authenticated users
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actionAdminDashboard()
    {
        // Only admin users can access this
        return $this->render('admin-dashboard');
    }
    
    public function actionManageUsers()
    {
        // Only admin users can access this
        return $this->render('manage-users');
    }
}