<?php

namespace Modules\Account\Repositories;

use Exception;
use App\Models\User;
use App\Traits\LogError;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Account\Entities\Contact;
use App\Http\Resources\API\UserResource;

/**
 * Class CommentRepository
 * @package App\Repositories\V1\Comments
 * @version February 7, 2020, 8:54 am UTC
*/

class ContactRepository extends BaseRepository {
    use LogError;
    use ApiResponser;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'owner',
        'account_id',
        'updated_by',
        'user_id',

    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable() {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model() {
        return Contact::class;
    }

    public function createContact($user, $request) {
        $this->model->create([
            'account_id' => $request->account_id ?? 3,
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'avatar' => $request->avatar ?? '',
            'status' => 1
        ]);
    }
    public function updateContact($entry, $request) {
        $contact = $this->model->where('user_id', $entry->id)->first();
        if (!empty($contact)) {
            $contact->update(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'account_id' => $request->account_id,
                    'email' => $entry->email,
                    'phone' => $entry->phone,
                    'avatar' => $request->avatar
                ]
            );
        }
        return $contact;
    }

    public function convertContactToUser() {
        $request = request();
        $contact = $this->model->find($request->id);
        $roleID = json_decode($request->roles, true);
        $name = $contact->first_name . ' ' . $contact->last_name;

        if ($request->user_id) {
            $user = User::where('id', $contact->user_id)->update([
                'name' => $name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'password' => Hash::make($request->password),
                'roles' => $roleID
            ]);
            $user->roles()->sync($roleID);

        } else {
            try {
                $walletRepository = class_exists('Modules\\Wallet\\Repositories\WalletRepository')
                    ? 'Modules\\Wallet\\Repositories\WalletRepository'
                    : '';
                DB::beginTransaction();
                $user = User::create([
                        'name' => $name,
                        'email' => $contact->email,
                        'phone' => $contact->phone,
                        'password' => Hash::make($request->password),
                        'roles' => $roleID,
                    ]);

                $user->roles()->sync($roleID);
                if ($user) {
                    $this->model->where('id', $request->id)->update([
                        'user_id' => $user->id
                    ]);
                    if ($walletRepository) {
                        collect(json_decode(config('settings.default_wallet_create_for_user'), true))
                            ->each(function ($v) use ($user, $walletRepository) {
                                $user->type = $v['wallet_type'];
                                $user->name = $v['wallet_name'];
                                resolve($walletRepository)->createWallet($user);
                            });
                    }
                }
                DB::commit();
                return $this->successResponse(new UserResource($user), 'Register Successfully', 200);
            } catch(Exception $e) {
                $this->logError($e, get_class($this), __FUNCTION__);
                DB::rollback();
                return $this->errorResponse('Something went wrong', 500);
            }
        }
    }

    public function checkContact($phone) {
        $contact = $this->model->where('phone', $phone)->first();
        if($contact){
            return 'contact/'.$contact->id.'/show';
        }else{
            return false;
        }

    }

    public function checkContactId($phone, $account_id) {
        $contact = $this->model->where('phone', $phone)->where('account_id', $account_id)->first();
        if($contact){
            return $contact->id;
        }else{
            $contact = $this->model->where('phone', $phone)->first();
            if (isset($contact->other_accounts)) {
                $data = in_array($account_id, $contact->other_accounts);
                if($data != false){
                    return $contact->id;
                }
            }
            return false;
        }
    }
}
