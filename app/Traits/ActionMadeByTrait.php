<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

trait ActionMadeByTrait {

    public function createdBy() {
        if (!Schema::hasColumn($this->getTable(), 'created_by')) {
            return false;
        }
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy() {
        if (!Schema::hasColumn($this->getTable(), 'updated_by')) {
            return false;
        }
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy() {
        if (!Schema::hasColumn($this->getTable(), 'deleted_by')) {
            return false;
        }
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getCreatedByFullNameAttribute() {
        return optional($this->createdBy)->name;
    }

    public function getUpdatedByFullNameAttribute() {
        return optional($this->updatedBy)->name;
    }

    public function getDeletedByFullNameAttribute() {
        return optional($this->deletedBy)->name;
    }

    public function hasAttribute($attr) {
        return array_key_exists($attr, $this->attributes);
    }

    public static function BootActionMadeByTrait() {
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model = $model->actionBy($model, 'created_by');
            }
        });

        static::updating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model = $model->actionBy($model, 'updated_by');
            }
        });
    }

    public function actionBy($model, $type) {
        if (Auth::check()) {
            $userId = request()->{$type};

            if (!$userId) {
                $userId = backpack_user() ? backpack_user()->id : Auth::user()->id;
            }

            $model->{$type} = $userId;
        }
        return $model;
    }

}
