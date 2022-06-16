<?php

namespace Modules\Type\Entities;

use App\Traits\UploadTrait;
use Kalnoy\Nestedset\NodeTrait;
use App\Traits\ForceDeleteTrait;
use App\Traits\ActionMadeByTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BaseTrait\BaseModelTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ReorderTraits\ParentDepthTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class Type
 * @package App\Models\V1\Types
 * @version February 18, 2020, 1:22 am UTC
 *
 * @property string ref_id
 * @property string ref_resource
 * @property string name
 * @property integer parent_id
 * @property integer lft
 * @property integer rgt
 * @property integer depth
 * @property integer create_by
 * @property integer update_by
 */
class Type extends Model implements Auditable
{
    use CrudTrait;
    use SoftDeletes;
    use UploadTrait;
    use NodeTrait;
    use ParentDepthTrait;
    use ForceDeleteTrait;
    use ActionMadeByTrait;
    use BaseModelTrait;
    use \OwenIt\Auditing\Auditable;


    public $entityName = 'type';
    protected $primaryKey = 'id';
    public $table = 'types';
    protected $dates = ['deleted_at'];
    public $ajaxField = 'name';

    public $fillable = [
        'name',
        'code',
        'icon',
        'description',
        'active',
        'parent_id',
        'display_on_frontend',
        'display_on_backend',
        'require_authentication',
        'ios_class',
        'android_class',
        'web_class',
        'category',
        'order',
        'option',
        'lft',
        'rgt',
        'depth',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'icon' => 'string',
        'description' => 'string',
        'active' => 'boolean',
        'parent_id' => 'integer',
        'display_on_frontend' => 'boolean',
        'display_on_backend' => 'boolean',
        'require_authentication' => 'boolean',
        'ios_class' => 'string',
        'android_class' => 'string',
        'web_class' => 'string',
        'category' => 'boolean',
        'order' => 'integer',
        'option' => 'boolean',
        'lft' => 'integer',
        'rgt' => 'integer',
        'depth' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer'
    ];

    public static function rulesTypesBackpack() {
        $maxStringRule = 'required|string|max:255';
        return [
            'code' => $maxStringRule,
            'name' => $maxStringRule,
            'order' => 'required|nullable|integer',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function allQuery()
    {
        return $this->hasMany(self::class);
    }
    public function objectables() {
        if (!class_exists('Modules\\Wallet\\Entities\\WalletAction')) {
            return false;
        }
        return $this->morphMany('Modules\\Wallet\\Entities\\WalletAction', 'objectable');
    }

    /**
     * SCOPE BELOW ONLY DECLARE WHEN DEPTH = 1
     */
    public function scopeAjaxSelectType($query, $value)
    {
        $walletType = $this->where('code', 'wallet_types')->first();
        return $query->where([['code', 'LIKE', '%' . $value . '%'], ['parent_id', $walletType->id]]);
    }

    public function scopeGetType($query)
    {
        return $query->with('children');
    }

    public function scopeIsActiveIsCategory($query)
    {
        return $query->where('active', true)->where('category', true);
    }

    public function scopeIsActiveIsOption($query)
    {
        return $query->where('active', true)->where('category', false);
    }

    public function scopeSearchName($query, $value = false)
    {
        return $query->orWhereRaw('LOWER(name) LIKE ?', ['%'.$value.'%']);
    }

    public function scopeTypeDynamicScope($query, $value)
    {
        return $query->whereIn('parent_id', function($query) use($value) {
            $query->select('id')->from('types')->where('parent_id', $value);
        })
            ->get()
            ->pluck('name', 'name');
    }

    public function getIconPathAttribute()
    {
        return is_null($this->icon) ? "assets/default.png" : $this->icon;
    }

    public function getIconSmallAttribute()
    {
        return $this->myFileExist($this->icon, 'uploads');
    }

    public function getTypeNameAttribute()
    {
        return $this->name;
    }

    public static function getDataTableColumnExtra()
    {
        return ['created_at', 'updated_at'];
    }

    public function getLftName()
    {
        return 'lft';
    }

    public function getRgtName()
    {
        return 'rgt';
    }
    public function getParentNameAttribute()
    {
        return $this->parent ? $this->parent->name : null;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setIconAttribute($value)
    {
        $this->uploadImage($value, 'icon', 'uploads', "uploads/images/" . date('Ym'));
    }
}
