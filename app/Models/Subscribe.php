<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscribe extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'client',
        'service',
        'screen',
        'start',
        'end',
        'created_by',
    ];

    protected $appends = [
        'client_name',
        'service_name',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getClient()
    {
        return $this->belongsTo(Client::class, 'client');
    }

    public function getService()
    {
        return $this->belongsTo(Service::class, 'service');
    }

    public function getScreen()
    {
        return $this->belongsTo(Screen::class, 'screen');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getClientNameAttribute()
    {
        return $this->getClient ? $this->getClient->name : null;
    }

    public function getServiceNameAttribute()
    {
        return $this->getService ? $this->getService->name : null;
    }
}
