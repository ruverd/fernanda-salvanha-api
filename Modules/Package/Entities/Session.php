<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'package_id','google_event','number','date','confirmed','paid'
    ];

    /**
     * Return package
     *
     * @return Collection
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
