<?php

namespace Modules\Entities\Modules\Package\Repositories;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class PackageRepository.
 *
 * @package namespace Modules\Entities\Modules\Package\Repositories;
 */
class PackageRepository extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
