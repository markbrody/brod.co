<?php

namespace App\Traits;

trait WithoutTimestamps
{
    protected static function boot() {
        parent::boot();
        static::updating(function ($model) {
            $model->timestamps = false;
        });
        static::updated(function ($model) {
            $model->timestamps = true;
        });
    }

    public function setUpdatedAt($value) {}

    public function getUpdatedAtColumn() {
        return "";
    }
}

