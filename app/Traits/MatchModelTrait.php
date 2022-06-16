<?php

namespace App\Traits;

use App\Models\Level;
use App\Models\Contest;
use App\Models\Question;
use App\Models\WorkShop;

trait MatchModelTrait {

    public function actionType($table, $value, $type = 'find_id') {

        $model = $this->modelMatching($table);
        if (!$model) {
            return false;
        }
        switch ($type) {
            case 'find_id':
                $data = $model::find($value);
                break;
            case 'model':
                $data = new $model;
                break;
            case 'ajax':
                $data = $model::AjaxSelect2Single($value);
                break;
            case 'account_number':
                $data = $model::AjaxWallet($value);
                break;
            case 'wallet_type':
                $data = $model::AjaxSelectType($value);
                break;
            default:
                $data = false;
                break;
        }
        return $data;
    }

    public function modelMatching($table) {

        switch ($table) {
            case 'merchants':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Merchant');
                break;
            case 'accounts':
                $model = $this->checkModelExist('Modules\\Account\\Entities\\Account');
                break;
            case 'products':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Product');
                break;
            case 'currencies':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Currency');
                break;
            case 'users':
                $model = $this->checkModelExist('App\\Models\\User');
                break;
            case 'wallets':
                $model = $this->checkModelExist('Modules\\Wallet\\Entities\\Wallet');
                break;
            case 'types':
                $model = $this->checkModelExist('Modules\\Type\\Entities\\Type');
                break;
            case 'orders':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Order');
                break;
            case 'order':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Order');
                break;
            case 'transaction':
                $model = $this->checkModelExist('Modules\\Payment\\Entities\\Transaction');
                break;
            case 'campaigns':
                    $model = $this->checkModelExist('Modules\\Loyalty\\Entities\\Campaign');
                    break;
            case 'contact':
                $model = $this->checkModelExist('Modules\\Account\\Entities\\Contact');
                break;
            case 'user':
                $model = $this->checkModelExist('App\\Models\\User');
                break;
            case 'banks':
                $model = $this->checkModelExist('Modules\\Wallet\\Entities\\Bank');
                break;
            default:
                $model = false;
                break;
        }

        return $model;
    }

    public function checkModelExist($model) {

        return class_exists($model) ? $model : '';
    }
}
