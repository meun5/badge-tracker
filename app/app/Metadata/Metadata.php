<?php

namespace app\Metadata;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Metadata extends Eloquent
{
    protected $table = 'tr_metadata';

    protected $fillable = [
        'name',
        'metadata',
    ];

    protected $data = [];

    public function listBadges() {

        $data = $this->where('type', 'badge')->first();

        $data = json_decode(base64_decode($data));

        return $data;
    }

}
