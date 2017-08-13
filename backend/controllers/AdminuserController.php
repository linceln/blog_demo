<?php

namespace backend\controllers;

use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use common\models\AuthAssignment;
use common\models\AuthItem;
use Yii;
use common\models\Adminuser;
use common\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminuserController implements the CRUD actions for Adminuser model.
 */
class AdminuserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Adminuser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminuserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Adminuser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Adminuser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $adminuser = $model->signup()) {

            return $this->redirect(['view', 'id' => $adminuser->id]);

        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Adminuser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Adminuser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 授权
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionAuthorize($id)
    {
        $allRoles = AuthItem::find()
            ->select(['description'])
            ->where(['type' => 1])
            ->indexBy('name')
            ->orderBy(['name' => SORT_DESC])
            ->column();

        $currentRoles = AuthAssignment::find()
            ->select('item_name')
            ->where(['user_id' => $id])
            ->column();


        if (isset($_POST['role'])) {

            AuthAssignment::deleteAll(['user_id' => $id]);

            $roles = $_POST['role'];
            foreach ($roles as $role) {

                $assignment = new AuthAssignment();
                $assignment->item_name = $role;
                $assignment->user_id = $id;
                $assignment->created_at = time();
                $assignment->save();
            }
            return $this->redirect('index');

        }

        return $this->render('authorize', [
            'username' => Adminuser::find()->where(['id' => $id])->one()->username,
            'currentRoles' => $currentRoles,
            'allRoles' => $allRoles
        ]);
    }

    /**
     * 重置密码
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionPassword($id)
    {
        $model = new ResetPasswordForm();
        $model->fillData($id);

        if ($model->load(Yii::$app->request->post()) && $model->resetPassword($id)) {

            return $this->redirect(['view', 'id' => $id]);
        } else {

            return $this->render('resetPassword', [
                'model' => $model
            ]);
        }
    }

    /**
     * Finds the Adminuser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Adminuser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Adminuser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
