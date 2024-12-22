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
        'formatted_dates'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service');
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class, 'screen');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getClientNameAttribute()
    {
        return $this->client ? $this->client->name : null;
    }

    public function getServiceNameAttribute()
    {
        return $this->service ? $this->service->name : null;
    }

    public function getFormattedDatesAttribute()
    {
        return [
            'start' => $this->start ? $this->start->format('Y-m-d') : null,
            'end' => $this->end ? $this->end->format('Y-m-d') : null,
        ];
    }
}
