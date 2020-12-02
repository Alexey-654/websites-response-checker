<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\WebsiteChecker;
use app\models\HttpWebsiteChecker;
use Carbon\Carbon;

// use yii\helpers\VarDumper;

class WebsiteCheckerController extends Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            $session = Yii::$app->session;
            $websites = $session->get('websites') ?? [];
            $websitesWithResponse = (new HttpWebsiteChecker())->getStatusResponse($websites);
        } else {
            $websitesWithResponse = WebsiteChecker::getWebsitesWithResponse(\Yii::$app->user->id);
        }

        $model = new WebsiteChecker();
        $time = Carbon::now('Europe/Moscow')->format('H:i');
        return $this->render("website-checker", compact('model', 'websitesWithResponse', 'time'));
    }

    public function actionStore()
    {
        $values = \Yii::$app->request->post('WebsiteChecker');
        if (!Yii::$app->user->isGuest) {
            $model = new WebsiteChecker();
            $model->user_id = \Yii::$app->user->id;
            $model->name = $values['name'];
            $model->url = $values['url'];
            if ($model->validate()) {
                $model->save();
                Yii::$app->session->setFlash('success', "Сайт - $model->name успешно добавлен.");
            } else {
                Yii::$app->session->setFlash('danger', "Введены некорректные данные");
            }
        } else {
            $session = Yii::$app->session;
            $websites = $session['websites'];
            $id = is_array($websites) ? count($websites) : 0;
            $websites[] = ['id' => $id, 'name' => $values['name'], 'url' => $values['url']];
            $session['websites'] = $websites;
            Yii::$app->session->setFlash('success', "Сайт - {$values['name']} успешно добавлен.");
        }

        return $this->redirect('/website-checker');
    }

    public function actionDestroy()
    {
        $request = \Yii::$app->request->post();
        if (!Yii::$app->user->isGuest) {
            $model = new WebsiteChecker();
            $website = $model::findOne($request['id']);
            $website->delete();
            Yii::$app->session->setFlash('info', "Сайт - $website->name удален из списка отслеживаемых");
        } else {
            unset($_SESSION['websites'][$request['id']]);
            Yii::$app->session->setFlash('info', "Сайт удален из списка отслеживаемых");
        }

        return $this->redirect('/website-checker');
    }
}
