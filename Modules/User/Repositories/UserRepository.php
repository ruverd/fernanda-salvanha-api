<?php

namespace Modules\User\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\User\Entities\User;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class UserRepository
 *
 * @package namespace Modules\Package\Repositories;
 */
class UserRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }    
}