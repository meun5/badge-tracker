<?php

namespace app\Gear;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Gear extends Eloquent
{
    protected $table = 'gear';

    protected $fillable = [
        'name',
        'brand',
        'amount',
        'status',
        'serial',
        'type',
        'enabled',
        'checkout_history',
    ];

    public function getAll() {
        return $this->where('enabled', true)->get();
    }

    public function updateCheckOut($json)
    {
        return $this->update([
            'checkout_history' => $json,
        ]);
    }
}
