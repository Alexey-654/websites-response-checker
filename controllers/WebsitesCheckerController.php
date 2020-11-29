<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\WebsitesChecker;
use app\models\HttpWebsiteChecker;
use yii\helpers\VarDumper;

class WebsitesCheckerController extends Controller
{
    public function actionIndex()
    {
        $websites = WebsitesChecker::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
        $websitesWithResponse = (new HttpWebsiteChecker())->getStatusResponse($websites);
        $model = new WebsitesChecker();

        return $this->render("websites-checker", compact('model', 'websitesWithResponse'));
    }

    public function actionStore()
    {
        $model = new WebsitesChecker();
        $values = \Yii::$app->request->post('WebsitesChecker');
        $model->name = $values['name'];
        $model->url = $values['url'];
        $model->save();
        Yii::$app->session->setFlash('success', 'Сайт успешно добавлен.');

        return $this->redirect('/websites-checker');
    }

    public function actionDestroy()
    {
        $request = \Yii::$app->request->post();
        $website = WebsitesChecker::findOne($request['id']);
        $website->delete();
        Yii::$app->session->setFlash('info', "Сайт удален из списка отслеживаемых");

        return $this->redirect('/websites-checker');
    }
}
