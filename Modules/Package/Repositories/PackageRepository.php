<?php

namespace Modules\Package\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Package\Entities\Package;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class PackageRepository
 *
 * @package namespace Modules\Package\Repositories;
 */
class PackageRepository extends BaseRepository implements RepositoryInterface
{
    protected $package = null;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Package::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }    

    /**
     * Sync package data
     *
     * @param int $user_id
     * @param object $session
     * @return object
     */
    public function syncData($user_id,$session)
    {
        if($this->willBeCreated($user_id,$session)){
            $this->setPackage($this->model->create([
                'user_id' => $user_id, 
                'service' => $session->service,
                'quantity' => $session->quantity,
                'start' => $session->dateTime,
                'cost' => $session->cost
            ]));
        }

        if($session->number == $session->quantity){
            echo "update";
            
            $this->model
                ->where('end',null)
                ->where('id',$this->getPackage()->id)
                ->update([
                    'end' => $session->dateTime
                ]);  
        }
        return $this->getPackage();
    }

    /**
     * Get last package opened for that user
     *
     * @param int $user_id
     * @return mixed
     */
    public function getLastOpened($user_id)
    {
        $package = $this->model
                        ->where('user_id',$user_id)
                        ->where('end',null)
                        ->orderBy('created_at', 'desc')
                        ->take(1)
                        ->first();
        return ($package) ? $package : false;
    }

    /**
     * Get last package opened for that user
     *
     * @param int $user_id
     * @param dateTime $start
     * @return mixed
     */
    protected function exists($user_id,$start)
    {
        $package = $this->model
                        ->where('user_id',$user_id)
                        ->where('start',$start)
                        ->first();
        return ($package) ? $this->setPackage($package) : false;
    }

    protected function setPackage($package)
    {
        $this->package = $package;
        return $this->package;
    }

    protected function getPackage()
    {
        return $this->package;
    }

    protected function willBeCreated($user_id,$session)
    {
        if($session->number !== 1){
            return false;
        } 

        $package = $this->getLastOpened($user_id);
        $flag = $package 
                    ? ( $package->start !== $session->dateTime ? true : false ) 
                    : true;
        if($flag){
            return $this->exists($user_id,$session->dateTime) ? false : true;
        } 
        $this->setPackage($package);
        return false;
    }
}