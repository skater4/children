<?php
namespace app\models;
use Yii;
use app\components\Csc;

class UserRoles {
    public static function getRoles(){
        return [
            'pupil' => Yii::t('common', 'Воспитанник'),
            'volunteer' => Yii::t('common', 'Волонтер'),
        ];
    }

    public static function getRolesPermissions(){
        return [
            'pupil' => [],
            'volunteer' => [],
        ];
    }
}