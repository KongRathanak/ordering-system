<?php

namespace Modules\Account\Observers;

use Modules\Account\Entities\Account;
use Modules\Payroll\Entities\Payroll;
use Modules\Account\Repositories\AccountRepository;

class AccountObserver
{
    public function updated(Account $account){

        if($account->getOriginal('parent_id') != $account->parent_id || $account->forceChildUpdate){
            $child = $account->children->pluck('id');
            if (count($child)) {
                $getChild = Account::whereIn('id', $child)->get();
                    $getChild->each(function ($child) use($account) {
                    $child->depth = $account->depth + 1;
                    $child->forceChildUpdate = true;
                    $child->save();
                });
            }
        }
    }
    public function deleting(Account $accounl)
    {
        $checkAccId = Payroll::where('account_id', $accounl->id)->count();
        if ($checkAccId) {
            request()->merge(['event_error_msg' => trans('zpoin.this_record_can_not_delete_it_already_in_used')]);
            return false;
        }
        $message = resolve(AccountRepository::class)->deleteAccount($accounl->id);
        if ($message) {
            request()->merge(['event_error_msg' => $message]);
            return false;
        }
    }
}
