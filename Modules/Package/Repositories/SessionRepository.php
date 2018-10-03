<?php

namespace Modules\Package\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Package\Entities\Session;
use Prettus\Repository\Contracts\RepositoryInterface;


/**
 * Class SessionRepository
 *
 * @package namespace Modules\Package\Repositories;
 */
class SessionRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Session::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Sync session data
     *
     * @param int $package_id
     * @param object $session
     * @return mixed
     */
    public function syncData($package_id,$session)
    {
        return $this->model->updateOrCreate(
            [
                'package_id' => $package_id,
                'google_event' => $session->id, 
                'number' => $session->number,
                'date' => $session->dateTime
            ],
            ['paid' => $session->paid]
        );
    }

    /**
     * Check if will create session
     *
     * @param int $package_id
     * @param object $session
     * @return bool
     */
    protected function willBeCreated($package_id,$session)
    {      
        return $this->exists($package_id,$session) ? false : true;
    }

    /**
     * Check if already exist register
     *
     * @param int $package_id
     * @param object $session
     * @return mixed
     */
    protected function exists($package_id,$session)
    {
        $session = $this->model
                        ->where('package_id',$package_id)
                        ->where('number',$start)
                        ->first();
        return ($session) ? $session : false;
    }
}