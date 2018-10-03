<?php

namespace Modules\Calendar\Entities;

use Spatie\GoogleCalendar\Event as EventGoogle;
use Modules\Core\Traits\CurrencyTrait;
use Modules\Calendar\Traits\EventTrait;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * Calendar class model
 */
class CalendarOld 
{
    use EventTrait, 
        CurrencyTrait;

    protected 
        $collection,
        $packageStart,
        $packageService,
        $packageCost,
        $packagePaid,
        $packagePaidTotal, 
        $packageNumber,
        $params;

      /**
     * Create Collection
     *
     * @return Object Collection
     */
    protected function createCollection()
    {
        $self = $this;
        $collection = EventGoogle::get(Carbon::parse('first day of January 2018'),Carbon::parse(),$this->__get('params'))
                ->map(function ($info) use($self){
                    return static::createEvent($info,$self);
                })
                ->filter()
                ->values();
        return $this->__set('collection',$collection);
    }

    /**
     * Magic method to set 
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;
        return $this->{$name};
    }

    /**
     * Magic method to get
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Mount items for collection
     *
     * @param Collection $info
     * @param Object $self 
     * @return Object Static
     */
    public static function createEvent($info,$self)
    {
        $sessionNumber = $self->getSessionNumber($info->description);
        if($sessionNumber){
            $event = new static();
            $event->id      = $info->id;
            $event->package = ($sessionNumber == 1) 
                                ? $self->__set('packageNumber',$info->startDateTime->format('YmdHis')) 
                                : $self->__get('packageNumber');
            $event->name = trim($info->name);
            $event->phone = $self->getPhone($info->description);
            $event->service = ($sessionNumber == 1) 
                                ? $self->__set('packageService',$self->getService($info->description)) 
                                : $self->__get('packageService');
            $event->sessionNumber =  $sessionNumber;
            $event->start = ($sessionNumber == 1) 
                                        ? $self->__set('packageStart',$info->startDateTime->format('d/m/Y H:i:s')) 
                                        : $self->__get('packageStart');;
            $event->dateTime = $info->startDateTime->format('d/m/Y H:i:s');
            $event->cost = ($sessionNumber == 1) 
                                ? $self->__set('packageCost',$self->moneyFormat($self->getPackageCost($info->description))) 
                                : $self->__get('packageCost');
            $event->paid = $self->__set('packagePaid',$self->moneyFormat($self->getPaidEvent($info->description)));
            $event->paidTotal = ($sessionNumber == 1) 
                                    ? $self->__set('packagePaidTotal',$self->moneyFormat($self->getPaidEvent($info->description))) 
                                    : $self->__set('packagePaidTotal',$self->__get('packagePaidTotal') + $self->moneyFormat($self->getPaidEvent($info->description)));
            return $event;
        }
        return false;
    }

    /**
     * Load data collection
     *
     * @return Object Collection
     */
    protected function loadCollection()
    {
        $collection = $this->__get('collection');
        return ($collection) ? $collection : $this->createCollection($this->__get('params'));
    }

    /**
     * Get events
     *
     * @param array $params
     * @return Object Collection
     */
    public function getEvents($params = [])
    {
        return $this->loadCollection($this->__set('params', $params));
    }

    /**
     * Get users
     *
     * @param array $params
     * @return Object Collection
     */
    public function getUsers($params = ['q' => 'Pacote:'])
    {
        $collection = $this->loadCollection($this->__set('params', $params))->groupBy('name');
        return $collection
                    ->map(function ($info){
                        $user = new static();
                        $user->name = $info[count($info)-1]->name;
                        $user->phone = $info[count($info)-1]->phone;
                        return $user;
                    });
    }

    /**
     * Get packages
     *
     * @param array $params
     * @return Object Collection
     */
    public function getPackages($params = [])
    {
        $collection = $this->loadCollection($this->__set('params', $params))->groupBy('package');
        dd($collection);
        return $collection
                    ->map(function ($info){
                        $package = new static();
                        $package->package = $info[count($info)-1]->package;
                        $package->name = $info[count($info)-1]->name;
                        $package->phone = $info[count($info)-1]->phone;
                        $package->service = $info[count($info)-1]->service;
                        $package->sessionNumber =  $info[count($info)-1]->sessionNumber;
                        $package->start = $info[count($info)-1]->start;
                        $package->end = $info[count($info)-1]->dateTime;
                        $package->cost = $info[count($info)-1]->cost;
                        $package->paidTotal = $info[count($info)-1]->paidTotal;
                        return $package;
                    });
    }

    /**
     * Get Sessions of package
     *
     * @param int $package
     * @return Object Collection
     */
    public function getSessions($package)
    {
        return $this->__get('collection')->where('package',$package);
    }
}