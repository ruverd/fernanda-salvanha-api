<?php

namespace Modules\Core\Services;

use Modules\Core\Contracts\Sync;
use Illuminate\Support\Facades\Hash;

/**
 * Class responsible for updating data retrieved from Google Calendar
 * 
 * @author Ruver Dornelas <ruverd@gmail.com>
 */
class CalendarSync implements Sync
{
    protected 
        $calendarRepository,
        $userRepository,
        $packageRepository,
        $sessionRepository;

    /**
     * Class Construtor
     *
     * @param Object $calendarRepository
     * @param Object $userRepository
     * @param Object $packageRepository
     * @param Object $sessionRepository
     */
    public function __construct($calendarRepository,$userRepository,$packageRepository,$sessionRepository)
    {
        $this->calendarRepository = $calendarRepository;  
        $this->userRepository = $userRepository;  
        $this->packageRepository = $packageRepository;  
        $this->sessionRepository = $sessionRepository;  
    }

    /**
     * Update all
     */
    public function all()
    {
        $this->users();
        $this->data();
    }

    /**
     * Update users
     */
    public function users()
    {
        foreach ($this->calendarRepository->getUsers()->all() as $user) {
            if(!$this->userRepository->findByField('phone', $user->phone)->first()){
                $this->userRepository->create([
                    'name' => $user->name, 
                    'phone' => $user->phone,
                    'password' => Hash::make(env('USER_DEFAULT_PASSWORD'))
                ]);    
            }
        }
    }

    /**
     * Update packages and sessions
     */
    public function data()
    {
        foreach ($this->userRepository->findByField('admin', 0)->all() as $user) {
            foreach ($this->calendarRepository->getSessions($user->name)->all() as $session) {
                $package = $this->packageRepository->syncData($user->id,$session);
                $this->sessionRepository->syncData($package->id, $session);  
            }
        }
    }
}
