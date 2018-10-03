<?php
namespace Modules\Event\Http\Traits;

trait EventTrait
{   
    static $services = [
        'Modeladora','Relaxante','Drenagem','Limpeza'
    ];

    static $events = [
        'Avulso' => 0,'Avulsa' => 0,'Primeira' => 1,'Segunda' => 2,
        'Terceira' => 3,'Quarta' => 4,'Quinta' => 5,'Sexta' => 6,
        'Sétima' => 7,'Oitava' => 8,'Nona' => 9,'Décima' => 10
    ];

    /**
     * Get the phone inside of string 
     *
     * @param string $dirtyString
     * @param bool $removeCharacter
     * @return mixed
     */
    public function getPhone($dirtyString,$removeCharacter = false)
    {
        $matches = [];
        preg_match_all('/[0-9]{10}|[0-9]{3}[\-][0-9]{6}|[0-9]{3}[\s][0-9]{6}|[0-9]{3}[\s][0-9]{3}[\s][0-9]{4}|[0-9]{3}[\-][0-9]{3}[\-][0-9]{4}|[\(][0-9]{3}[\)][\s][0-9]{3}[\s][0-9]{4}/', $this->clearDirtyString($dirtyString), $matches);
        foreach ($matches[0] as $phone) {
             return $removeCharacter ? str_replace(['-',' ','(',')'],"",$phone) : $phone;
        }
        return false;
    }

    /**
     * Get the event inside of string
     *
     * @param string $dirtyString
     * @param bool $number
     * @return mixed
     */
    public function getEvent($dirtyString,$number = false)
    {
        $arrayInfo = explode(" ", $this->clearDirtyString($dirtyString));
        foreach ($this->getListEvents() as $nameEvent => $numberEvent) {
            $key = array_search($nameEvent, $arrayInfo);
            if($key){
                return  $number ? $numberEvent : $nameEvent;   
            }
        }
        return false;
    }   

    /**
     * Get the event inside of string
     *
     * @param string $dirtyString
     * @return mixed
     */
    public function getSessionNumber($dirtyString)
    {
        $arrayInfo = explode(" ", $this->clearDirtyString($dirtyString));
        foreach ($this->getListEvents() as $nameEvent => $numberEvent) {
            $key = array_search($nameEvent, $arrayInfo);
            if($key){
                return  $numberEvent;   
            }
        }
        return false;
    }   

    /**
     * Remove some characters from string
     *
     * @param string $dirtyString
     * @return string
     */
    protected function clearDirtyString($dirtyString)
    {
        return trim(preg_replace('/\s+/', ' ', $dirtyString));
    }

    /**
     * All services name
     *
     * @return array
     */
    protected function getListServices()
    {
        return self::$services;
    }   

    /**
     * All sessions name
     *
     * @return array
     */
    protected function getListEvents()
    {
        return self::$events;
    }   

    /**
     * Return cost for package
     *
     * @param string $dirtyString
     * @return string
     */
    public function getPackageCost($dirtyString)
    {
        $matches = [];
        preg_match_all("/[\$][\d]*[\.][\d]{2}|[\$][\d]*/", $this->clearDirtyString($dirtyString), $matches);
        
        return count($matches[0]) 
               ? (count($matches[0]) == 2 ? $matches[0][0] : '0.00')
               : '0.00';
    }

    /**
     * Return paid for this event
     *
     * @param string $dirtyString
     * @return string
     */
    public function getPaidEvent($dirtyString)
    {
        $matches = [];
        preg_match_all("/[\$][\d]*[\.][\d]{2}|[\$][\d]*/", $this->clearDirtyString($dirtyString), $matches);
        
        return count($matches[0]) 
               ? (count($matches[0]) == 2 ? $matches[0][1] : $matches[0][0])
               : '0.00';
    }   

    /**
     * Get the service inside of string
     *
     * @param string $dirtyString
     * @return mixed
     */    
    public function getService($dirtyString)
    {
        $arrayInfo = explode(" ", $this->clearDirtyString($dirtyString));
        foreach ($this->getListServices() as $serviceName) {
            $key = array_search(trim($serviceName), $arrayInfo);
            if($key){
                return $serviceName;   
            }
        }
        return false;
    }
}