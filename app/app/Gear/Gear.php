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
        'check',
        'type',
        'enabled',
    ];

    public function checkOut() {
        $this->update([
            'check' => "true",
        ]);
    }

    public function checkIn() {
        $this->update([
            'check' => "false",
        ]);
    }

    public function getAll() {
        return $this->where('enabled', true)->get();
    }
}
