<?php  

namespace App\Services\Utilities;

class Year{

    protected static $years = [
        'I' => 'First year',
        'II' => 'Second year',
        'III' => 'Third year',
        'IV' => 'Fourth year',
    ];
    
    public static function all()
    {
        return static::$years;
    }
}