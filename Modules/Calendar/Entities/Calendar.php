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
class Calendar 
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
            $event->name = trim($info->name);
            $event->number =  $sessionNumber;
            $event->quantity =  $self->getQuantity($info->description);
            $event->dateTime = $info->startDateTime;
            $event->paid = $self->moneyFormat($self->getPaidEvent($info->description));
            $event->phone = $self->getPhone($info->description);
            $event->service = $self->getService($info->description);
            $event->cost = $self->moneyFormat($self->getPackageCost($info->description));
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
     * @return Object Collection
     */
    public function getUsers()
    {
        $collection = $this->loadCollection($this->__set('params', ['q' => 'Pacote']))
                           ->where('number', 1)
                           ->groupBy('name');
        return $collection
                    ->map(function ($info){
                        $user = new static();
                        $user->name = $info[count($info)-1]->name;
                        $user->phone = $info[count($info)-1]->phone;
                        return $user;
                    });
    }

    /**
     * Get sessions
     *
     * @param string $user
     * @return Object Collection
     */
    public function getSessions($user)
    {
        $collection = $this->loadCollection($this->__set('params', ['q' => $user]));    
        return $collection
                    ->map(function ($info){
                        $package = new static();
                        $package->id = $info->id;
                        $package->service = $info->service;
                        $package->number =  $info->number;
                        $package->quantity =  $info->quantity;
                        $package->dateTime = $info->dateTime;
                        $package->paid = $info->paid;
                        $package->cost = $info->cost;
                        return $package;
                    });
    }

    /**
     * Get Sessions of package
     *
     * @param int $package
     * @return Object Collection
     */
    // public function getSessions($package)
    // {
    //     return $this->__get('collection')->where('package',$package);
    // }
}