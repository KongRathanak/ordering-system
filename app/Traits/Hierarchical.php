<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Account;

trait Hierarchical {

    public $zillenniumId = 1;
    public $zpoinId = 2;
    public $individualId = 3;
    public $bankId = 4;

    public function account() {
        if (!class_exists('Modules\\Account\\Entities\\Account')) {
            return false;
        }

        return $this->belongsTo('Modules\\Account\\Entities\\Account', 'account_id', 'id');
    }

    public function scopeByAccountHierarchy($query) {
        $loginUser = backpack_user() ?? Auth::user();
        if ($loginUser->isSuperAdminRole()) {
            return $query;
        }

        $currentUserAcc = optional(optional($loginUser->contact)->account);
        if(request()->segment(2) == 'contact'){
            return $query->where(function ($q) use ($currentUserAcc){
                $acc = Account::whereBetween($currentUserAcc->getLftName(), [$currentUserAcc->getLft(), $currentUserAcc->getRgt()])->get()->pluck('id');
                $q->whereIn('account_id',$acc);
            });
        }
        return $query->whereHas('account', function ($q) use ($currentUserAcc) {
            return $q->whereBetween($currentUserAcc->getLftName(), [$currentUserAcc->getLft(), $currentUserAcc->getRgt()]);
        });
    }

    public static function BootHierarchical() {
        static::creating(function ($model) {
            $accountId = $model->account_id ?? request()->account_id;
            $user = backpack_user() ?? Auth::user();
            $accountId = $accountId ?? optional(optional($user)->contact)->account_id;
            if ($accountId) {
                $model->account_id = $accountId;
            }
        });
        static::updating(function ($model) {
            $accountId = $model->account_id ?? request()->account_id;
            $user = backpack_user() ?? Auth::user();
            $accountId = $accountId ?? optional(optional($user)->contact)->account_id;
            if ($accountId) {
                $model->account_id = $accountId;
            }
        });
    }

}
