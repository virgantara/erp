<?php

namespace app\controllers;

use Yii;
use app\models\MenuLayout;
use app\models\MenuLayoutSearch;
use app\models\MenuLayoutRbac;
use \app\rbac\models\AuthItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MenuLayoutController implements the CRUD actions for MenuLayout model.
 */
class MenuLayoutController extends Controller
{
    /**
     * {@inheritdoc}
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

    public function actionMap()
    {

        $listMenu = MenuLayout::find()->all();
        $listRole = AuthItem::find()->all();
        
        
        if(!empty($_POST['flag']))
        {

            MenuLayoutRbac::deleteAll();
            $index = 1;
            foreach($listMenu as $menu)
            {
                foreach($listRole as $role)
                {
                    if(!empty($_POST['ch_'.$menu->id.'_'.$role->name]))
                    {
                        $tmp = new MenuLayoutRbac;
                        $tmp->id = $index;
                        $tmp->role_name = $role->name;
                        $tmp->menu_id = $menu->id;
                        $tmp->save();
                        $index++;
                    }
                }
            }

        }

        $values = [];
        foreach($listMenu as $menu)
        {
            foreach($listRole as $role)
            {
                $tmp = MenuLayoutRbac::find()->where(['role_name'=>$role->name,'menu_id'=>$menu->id])->one();
                $values[$menu->id][$role->name] = !empty($tmp) ? 1 : 0;
            }
        }

        
        return $this->render('map',[
            'listMenu'=>$listMenu,
            'listRole' => $listRole,
            'values' => $values
        ]);
    }

    public function actionAjaxBulkSave()
    {
        if(Yii::$app->request->isPost)
        {
            $postData = $_POST['item'];

            // print_r($postData);exit;
            foreach($postData as $q1 => $m1)
            {
                $m = MenuLayout::findOne($m1['id']);
                $m->urutan = ($q1+1);
                $m->save();

                if(!empty($m1['children']))
                {
                    foreach($m1['children'] as $q2 => $m2)
                    {
                        $m = MenuLayout::findOne($m2['id']);
                        $m->urutan = ($q2+1);               
                        $m->save(); 

                        if(!empty($m2['children']))
                        {
                            foreach($m2['children'] as $q3 => $m3)
                            {
                                $m = MenuLayout::findOne($m3['id']);
                                $m->urutan = ($q3+1);                   
                                $m->save();

                                if(!empty($m3['children']))
                                {
                                    foreach($m3['children'] as $q4 => $m4)
                                    {
                                        $m = MenuLayout::model()->findByPk($m4['id']);
                                        $m->urutan = ($q4+1);                   
                                        $m->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }           

            $result = [
                'code' => 200,
                'message' => 'Menu Updated'
            ];
            echo json_encode($result);
        }
    }


    /**
     * Lists all MenuLayout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuLayoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuLayout model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MenuLayout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MenuLayout();
        $listParent = MenuLayout::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
            $parent = MenuLayout::findOne($_POST['MenuLayout']['parent']);
            $model->level = !empty($parent) ? $parent->level+1 : 1;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'listParent' => $listParent
        ]);
    }

    /**
     * Updates an existing MenuLayout model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $listParent = MenuLayout::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $parent = MenuLayout::findOne($_POST['MenuLayout']['parent']);
            $model->level = !empty($parent) ? $parent->level+1 : 1;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'listParent' => $listParent
        ]);
    }

    /**
     * Deletes an existing MenuLayout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuLayout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuLayout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuLayout::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
