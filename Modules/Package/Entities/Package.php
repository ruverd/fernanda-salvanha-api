<?php

namespace Modules\Package\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Package extends Model
{
    protected $fillable = [
        'user_id','service','quantity','start','end','cost'
    ];

    /**
     * Return user
     *
     * @return Collection
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return all sessions to one specific package
     *
     * @return Collection
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
