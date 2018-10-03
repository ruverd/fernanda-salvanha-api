<?php

namespace Modules\Repositories\Modules\Package\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Repositories\Modules\Package\Repositories\PackageRepositoryRepository;
use Modules\Entities\Modules\Package\Repositories\PackageRepository;
use Modules\Validators\Modules\Package\Repositories\PackageRepositoryValidator;

/**
 * Class PackageRepositoryRepositoryEloquent.
 *
 * @package namespace Modules\Repositories\Modules\Package\Repositories;
 */
class PackageRepositoryRepositoryEloquent extends BaseRepository implements PackageRepositoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PackageRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
