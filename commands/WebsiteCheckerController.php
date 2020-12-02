<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\WebsiteChecker;
use app\models\HttpWebsiteChecker;
use Carbon\Carbon;

// use yii\swiftmailer\Mailer;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WebsiteCheckerController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionSendEmailOnBadResponse($emailTo = null)
    {
        $emailTo = $emailTo ?? \Yii::$app->params['adminEmail'];
        $emailFrom = \Yii::$app->params['senderEmail'];
        $websites = WebsiteChecker::find()->orderBy(['id' => SORT_DESC])->asArray()->all();
        $websitesWithResponse = (new HttpWebsiteChecker())->getStatusResponse($websites);
        $bodyMessageHelloPart = "Hello! \nYour websites have errors -";
        $responseErrors = [];
        foreach ($websitesWithResponse as $website) {
            $string = "{$website['name']} {$website['url']} {$website['status']} {$website['reasonPhrase']}";
            if ($website['status'] !== 200) {
                if (isset($website['email_sended_at'])) {
                    $timeNow = Carbon::now('Europe/Moscow');
                    $lastEmailSendedAt = $website['email_sended_at'];
                    $timeDiff = $timeNow->diffInHours($lastEmailSendedAt);
                    if ($timeDiff > 3) {
                        $responseErrors[] = $string;
                        continue;
                    }
                    continue;
                }
                $responseErrors[] = $string;
            }
        }

        $finalMessage = $bodyMessageHelloPart . "\n" . \implode("\n", $responseErrors);
        if (!empty($responseErrors)) {
            \Yii::$app->mailer->compose()
            ->setFrom($emailFrom)
            ->setTo($emailTo)
            ->setSubject('Error report')
            ->setTextBody($finalMessage)
            ->send();
        }

        foreach ($websitesWithResponse as $website) {
            if ($website['status'] !== 200) {
                $model = WebsiteChecker::findOne($website['id']);
                $model->email_sended_at = date('c');
                $model->save();
            }
        }
        return ExitCode::OK;
    }
}
