<?php

namespace Modules\Account\Entities;

use Kalnoy\Nestedset\NodeTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseTrait\BaseModelTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ReorderTraits\ParentDepthTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Account extends Model implements Auditable
{
    use CrudTrait;
    use ParentDepthTrait;
    use BaseModelTrait;
    use ActionMadeByTrait;
    use SoftDeletes;
    use ForceDeleteTrait;
    use NodeTrait;
    use \OwenIt\Auditing\Auditable;


    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    public $entityName = 'account';
    public $forceChildUpdate = false;

    protected $table = 'accounts';
    protected $fillable = [
        'name',
        'industry',
        'address',
        'phone',
        'description',
        'type',
        'parent_id',
        'owner',
        'contact_id',
    ];
    protected $casts = [
        'name' => 'string',
        'industry' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'description' => 'string',
        'type' => 'string',
        'parent_id' => 'integer',
        'owner' => 'integer',
    ];


    public function requestRulesBackPack($request, $type = false) {
        $sometimeNullableSometime = 'sometimes|nullable|max:255';
        $requiredStringMax255 = 'required|string|max:255';
        $rules = [
            'name' => $requiredStringMax255,
            //'industry' => $requiredStringMax255,
            'address' => $sometimeNullableSometime,
            'type' => $sometimeNullableSometime,
            'phone' => 'sometimes|nullable|phone_number|unique:accounts,phone',
            'description' =>'sometimes|nullable|string|max:1000',
            'parent_id' => 'sometimes|nullable|integer|exists:accounts,id',
            'owner' => 'sometimes|nullable|integer|exists:contacts,id',
        ];

        if ($type == 'update') {
                $rules['phone'] = 'sometimes|nullable|phone_number|unique:accounts,phone,'.$request->id ??  '';
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
    public function ownerAccount() {
        return $this->belongsTo(Contact::class, 'owner', 'id');
    }
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }
    public function children() {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeSearchText($query, $value = false) {
        return $query->WhereColumnConcats($value,['name']);
    }

    public function scopeAjaxSelect2Single($query, $value = false) {
        return $query->WhereColumnConcats($value,['name']);
    }
    public function scopeSearchBackpackFilter($query, $value = false)
    {
        return $query->where('name', 'ILIKE', '%'. $value . '%');
    }
    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getLftName() {
        return 'lft';
    }

    public function getRgtName() {
        return 'rgt';
    }

    public function getParentIdName() {
        return 'parent_id';
    }

    public function getParentNameAttribute() {
        return optional($this->parent)->name;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
