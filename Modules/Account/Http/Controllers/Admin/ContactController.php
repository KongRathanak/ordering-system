<?php

namespace Modules\Account\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Account\Http\Requests\UserConvertRequest;
use Modules\Account\Repositories\ContactRepository;

class ContactController extends Controller
{

    /**
     * Button Contact to User
     */
    public function convertContactToUser(UserConvertRequest $request)
    {
        return resolve(ContactRepository::class)->convertContactToUser($request);
    }

}
