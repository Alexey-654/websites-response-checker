<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\HttpWebsiteChecker;

class WebsiteChecker extends ActiveRecord
{
    // public $id;
    // public $user_id;
    // public $name;
    // public $url;
    // public $email_sended_at;
    // public $created_at;
    // public $updated_at;

    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            ['url', 'url', 'defaultScheme' => 'https'],
        ];
    }

        /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название сайта',
            'url' => 'Адрес сайта',
        ];
    }

    public static function getWebsitesWithResponse($userId)
    {
        $websites = self::find()->where(['user_id' => $userId])->orderBy(['id' => SORT_DESC])->asArray()->all();
        return (new HttpWebsiteChecker())->getStatusResponse($websites);
    }
}
