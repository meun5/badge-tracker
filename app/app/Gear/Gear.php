<?php

namespace app\Gear;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Gear extends Eloquent
{
    protected $table = 'tr_gear';

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
        $this->update([
            'checkout_history' => $json,
        ]);
    }
}
