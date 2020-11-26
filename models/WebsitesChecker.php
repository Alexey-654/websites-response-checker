<?php

namespace app\models;

use yii\db\ActiveRecord;

class WebsitesChecker extends ActiveRecord
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
            [['name', 'url'], 'required']
        ];
    }
}
