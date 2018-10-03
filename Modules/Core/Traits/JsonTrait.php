<?php
namespace Modules\Core\Traits;

trait JsonTrait
{
    /**
     * Array values to Json Object
     *
     * @param [array] $array
     * @return Obj
     */
    public function arrayToJsonObject($array = [])
    {
        return json_decode(json_encode($array, JSON_FORCE_OBJECT));   
    }
}