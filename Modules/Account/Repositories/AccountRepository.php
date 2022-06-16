<?php

namespace Modules\Account\Repositories;


use App\Models\User;
use Illuminate\Http\Request;
use Modules\Wallet\Entities\Wallet;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Account\Entities\Account;
use Modules\Account\Entities\Contact;
use Modules\Payment\Entities\Product;
use Modules\Payment\Entities\Currency;
use Modules\Payment\Entities\Merchant;
use Modules\Payment\Entities\Integration;
use Modules\Payment\Entities\ProductItemPrice;
use Modules\Payment\Entities\ProductPricingGrid;
use Modules\Wallet\Repositories\WalletRepository;
use Modules\Wallet\Traits\GenerateAccountNumberTrait;

/**
 * Class CommentRepository
 * @package App\Repositories\V1\Comments
 * @version February 7, 2020, 8:54 am UTC
*/

class AccountRepository extends BaseRepository
{
    use GenerateAccountNumberTrait;


    /**
     * @var array
     */
    protected $fieldSearchable = [
        'owner',
        'account',
        'updated_by'
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
        return Account::class;
    }
    public function ajaxNested(Request $request) {
        $searchTerm = $request->input('q');
        $form = collect($request->input('form'));
        $acc = $form->where('name','account_id')->pluck('value');
        $otherAcc = $form->where('name','other_accounts[]')->pluck('value')->merge($acc);
        $query = $this->model::query();

        if ($searchTerm) {
            $query = $query->SearchText($searchTerm);
        }

        $accounts = $query
            ->whereNotIn('id',$otherAcc)
            ->orderBy('lft')
            ->paginate(50)
            ->map(function ($v) {
                $v->name = str_repeat("-", (int)$v->depth > 1 ? (int)$v->depth - 1 : 0) . ' ' . $v->name;
                return $v;
            });

        return ['data' => $accounts];
    }
    public function deleteAccount($accountId){

        $tables = [
            Contact::class => 'account_id',
            Currency::class => 'account_id',
            Integration::class => 'account_id',
            Merchant::class => 'account_id',
            // Order::class => 'account_id',
            Product::class => 'account_id',
            ProductItemPrice::class => 'account_id',
            ProductPricingGrid::class => 'account_id',
            // Transaction::class => 'account_id',
            // Payout::class => 'account_id',
            // Deposit::class => 'account_id',
            // Wallet::class => 'account_id',
            // WalletAction::class => 'account_id',
            // WalletAudit::class => 'account_id',

        ];

        foreach($tables as $key => $val) {
            $pro = $key::where($val, $accountId)->count();
            switch ($key) {

                case Contact::class:
                        $id = 'id';
                        $model = 'Contact';
                    break;
                case Currency::class:
                        $id = 'id';
                        $model = 'Currency';
                    break;
                case Integration::class:
                        $id = 'id';
                        $model = 'Integration';
                    break;
                case Merchant::class:
                        $id = 'id';
                        $model = 'Merchant';
                    break;
                // case Order::class:
                //         $id = 'id';
                //         $model = 'Order';
                //     break;
                case Product::class:
                        $id = 'id';
                        $model = 'Product';
                    break;
                case ProductItemPrice::class:
                        $id = 'id';
                        $model = 'ProductItemPrice';
                    break;
                case ProductPricingGrid::class:
                        $id = 'id';
                        $model = 'ProductPricingGrid';
                    break;
                // case Transaction::class:
                //         $id = 'id';
                //         $model = 'Transaction';
                //     break;
                // case Payout::class:
                //         $id = 'id';
                //         $model = 'Payout';
                //     break;
                // case Deposit::class:
                //         $id = 'id';
                //         $model = 'Deposit';
                //     break;
                // case Wallet::class:
                //         $id = 'id';
                //         $model = 'Wallet';
                //     break;
                // case WalletAction::class:
                //         $id = 'id';
                //         $model = 'WalletAction';
                //     break;
                // case WalletAudit::class:
                //         $id = 'id';
                //         $model = 'WalletAudit';
                //     break;
                // case Integration::class:
                //         $id = 'id';
                //         $model = 'Integration';
                //     break;
                // case Merchant::class:
                //         $id = 'id';
                //         $model = 'Merchant';
                //     break;
                // case Order::class:
                //         $id = 'id';
                //         $model = 'Order';
                //     break;
                // case Product::class:
                //         $id = 'id';
                //         $model = 'Product';
                //     break;
                // case ProductItemPrice::class:
                //         $id = 'id';
                //         $model = 'ProductItemPrice';
                //     break;
                // case ProductPricingGrid::class:
                //         $id = 'id';
                //         $model = 'ProductPricingGrid';
                //     break;
                // case Transaction::class:
                //         $id = 'id';
                //         $model = 'Transaction';
                //     break;
                // case Payout::class:
                //         $id = 'id';
                //         $model = 'Payout';
                //     break;
                // case Deposit::class:
                //         $id = 'id';
                //         $model = 'Deposit';
                //     break;
                // case Wallet::class:
                //         $id = 'id';
                //         $model = 'Wallet';
                //     break;
                default:
                        $id = 'id';
                        $model = '';
                    break;
            }
            if($pro != 0){
                $pros = $key::where($val, $accountId)->take(5);
                $code = $pros->pluck($id)->toArray();
                $code = array_map(function ($item) {
                            return str_pad($item, 6, "0", \STR_PAD_LEFT);
                        },$code);
                collect($code)->implode(', ');
                $message = trans('zpoin.this_record_can_not_delete_it_already_in_used');
                if ($pro) {
                    return $message;
                }
            }
        }
        return false;
    }
    public function addUserAndWallet($request)
    {
        $email = str_replace(' ', '', $request->name).'@gmail.com';
        $user = User::where('email', $email)->first();
        Log::info('>>>>>> Check Import Job', [$user]);

        if($user){
            //Not Insert User
        }else{
            $user = User::create([
                'name' => $request->name,
                'account_id' => $request->id,
                'email' => $email,
                'password' => Hash::make('not4you'),
            ]);
            $user->roles()->sync(11);

            if($user)
            {
                $name = array($user->name);

                $contact = Contact::create([
                    'first_name' => array_shift($name),
                    'last_name' => implode(" ", $name),
                    'account_id' => $request->id,
                    'user_id' => $user->id,
                    'email' => $email,
                ]);

                $request->update([
                    'owner' => $contact->id,
                ]);

                $currencyId = config('settings.default_wallet_currency') ?? 1;

                $wallet = Wallet::create([
                    'name' => 'Payroll Balance',
                    'account_number' => $this->generateBarcodeNumber(),
                    'currency_id' => $currencyId,
                    'type' => 'Payroll',
                    'active' => true,
                    'user_id' => $user->id,
                    'created_by' => $user->id,
                    'account_id' => $request->id,
                ]);
                resolve(WalletRepository::class)->createWalletSuspend($wallet);
            }

            return $user;
        }
    }
}
