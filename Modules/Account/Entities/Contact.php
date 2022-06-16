<?php

namespace Modules\Account\Entities;

use App\Models\User;
use App\Traits\UploadTrait;
use App\Traits\Hierarchical;
use App\Traits\AccessorTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use App\Traits\RolePermissionTrait;
use Modules\Account\Entities\Account;
use Modules\Payment\Entities\Merchant;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseTrait\BaseModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use OwenIt\Auditing\Contracts\Auditable;

class Contact extends Model implements Auditable
{
    use AccessorTrait;
    use CrudTrait;
    use BaseModelTrait;
    use SoftDeletes;
    use ForceDeleteTrait;
    use ActionMadeByTrait;
    use UploadTrait;
    use Hierarchical;
    use \OwenIt\Auditing\Auditable;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $entityName = 'contact';
    protected $table = 'contacts';
    protected $fillable = [
        'first_name',
        'last_name',
        'user_id',
        'phone',
        'email',
        'address',
        'merchant_id',
        'position',
        'status',
        'account_id',
        'other_accounts',
        'created_by'
    ];
    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'address' => 'string',
        'user_id'  => 'integer',
        'merchant_id' => 'integer',
        'position' => 'string',
        'status' => 'boolean',
        'account_id' => 'integer',
        'other_accounts' => 'array'
    ];
    public function requestRulesBackPack($request, $type = false){
        $sometimeNullableSometime = 'sometimes|nullable|max:255';
        $requiredStringMax255 = 'required|string|max:255';
        $rules = [
            'first_name' => $requiredStringMax255,
            'last_name' => $requiredStringMax255,
            'address' => $requiredStringMax255,
            'phone' => 'required|phone_number|min:9|max:15|unique:contacts,phone',
            'email' => 'required|email:filter|max:255|unique:contacts,email',
            'position' => $sometimeNullableSometime,
            'status' =>'sometimes|nullable|boolean',
            'account_id' => 'sometimes|nullable|integer|exists:accounts,id',
            'merchant_id' => 'sometimes|nullable|integer|exists:merchants,id',
        ];
        if($type == 'update'){
            $rules['phone'] = $rules['phone'].",".$request->id ??  '';
            $rules['email'] = $rules['email'].",".$request->id ??  '';
        }
        return $rules;
    }
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function account() {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function merchant() {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
    public function createdBy() {
        return $this->belongsTo(self::class,'created_by', 'id');
    }
    public function updatedBy() {
        return $this->belongsTo(self::class,'updated_by', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeSearchText($query, $value = false) {
        return $query->WhereColumnConcats($value, ['id','first_name','last_name','phone']);
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getCreatedByNameAttribute() {

        return optional($this->createdBy)->fullName;
    }
    public function getUpdatedByNameAttribute() {

        return optional($this->updatedBy)->fullName;
    }
    public function getAccountNameAttribute() {
        return optional($this->account)->name;
    }
    public function UserName(): Attribute {
        return new Attribute(
          fn () => optional($this->user)->name
        );
    }
    public function FullName(): Attribute {
        return new Attribute(
          fn () => $this->first_name.' '.$this->last_name
        );
    }

    public function statusHtml(): Attribute {
        return new Attribute(
          fn () => $this->status ?
                    '<span class="badge badge-success">Active</span>' :
                    '<span class="badge badge-danger">Inactive</span>'
        );
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
