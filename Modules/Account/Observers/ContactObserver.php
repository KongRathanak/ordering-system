<?php

namespace Modules\Account\Observers;

use App\Models\User;
use UnexpectedValueException;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\Contact;
use Modules\Account\Repositories\ContactRepository;

class ContactObserver
{
    public function created(Contact $contact){
        $contact->user()->update([
            'name' => $contact->FullName,
        ]);
    }
    public function updated(Contact $contact){
        $contact->user()->update([
            'name' => $contact->FullName,
            'phone' => $contact->phone,
            'email' => $contact->email,
        ]);
    }
    public function deleting(Contact $contact)
    {
        $checkAccId = User::where('id', $contact->user_id)->count();
        if ($checkAccId) {
            request()->merge(['event_error_msg' => trans('zpoin.this_record_can_not_delete_it_already_in_used')]);
            return false;
        }
    }
}
