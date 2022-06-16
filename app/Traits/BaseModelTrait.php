<?php

namespace App\Traits\BaseTrait;

use Illuminate\Support\Facades\DB;

trait BaseModelTrait
{
    /*
    |--------------------------------------------------------------------------
    | CONFIGS
    |--------------------------------------------------------------------------
    */
    public function idPrefixConfig()
    {
        return (object)[
            'column' => $this->idPrefixColumn ?? 'id',
            'digit' => $this->idPrefixDigit ?? 6,
            'prefix' => $this->idPrefix ?? '0',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function makeIdPrefix()
    {
        $config = $this->idPrefixConfig();

        return str_pad(
            $this->{$config->column},
            $config->digit,
            $config->prefix,
            STR_PAD_LEFT
        );
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeIdPrefix($query, $text, $enableOrWhere = false)
    {
        $config = $this->idPrefixConfig();

        $prefix = $config->column.'::text';

        $sql = $config->column;

        $text = ltrim($text, $config->prefix);
        if (is_null($text) || $text == $config->prefix) {
            return $query;
        }
        if ($enableOrWhere) {
            return $query->orWhere($sql,'like' ,  $text."%");
        }

        return $query->where($sql,'like' ,  $text."%");
    }

    public function scopeOrderByIdPrefix($query, $columnDirection)
    {
        $config = $this->idPrefixConfig();

        return $query->orderBy($config->column, $columnDirection);
    }

    public function scopeWhereColumnConcats($query, $value, $column = [], $operator = ' ')
    {
        if (is_array($column) && count($column)) {

            $likeString = env('DB_CONNECTION') === 'pgsql' ? 'ILIKE' : 'like';
            $concat = implode(",'".$operator."',", $column);
            return $query->where(DB::raw("CONCAT({$concat})"), $likeString, '%'.$value.'%');
        }
        return $query;
    }

    public function scopeFlexiPaginate($query, $perPage = false)
    {
        $request = request();

        $setPerPage = $request->per_page ? $request->per_page : 10;

        if (!$perPage) {
            $perPage = $setPerPage;
        } else {
            if (!is_numeric($perPage)) {
                $perPage = $setPerPage;
            }
        }

        return $query->orderBy('id', 'DESC')->paginate($perPage);
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getIdPrefixAttribute()
    {
        return $this->makeIdPrefix();
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
