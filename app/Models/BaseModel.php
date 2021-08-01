<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
class BaseModel extends Model
{   
    
    /**
     * It allows you to customize the format with which we want to return the dates in the requests
     *
     * @param  DateTimeInterface $date
     * @return void
     */
    protected function serializeDate(DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
    
    /**
     * Returns the name of the model table
     *
     * @return void
     */
    public static function getTableName(){
        return with(new static)->getTable();
    }
    
    /**
     * It is used to capitalize phrases, used for example to store people's names
     *
     * @param  string $value
     * @return void
     */
    public function formatStringField($value)
    {
        return ucfirst(mb_strtolower($value));
    }
    
    /**
     * allows generating a condition by receiving a unique value or an array
     *
     * @param  object $query
     * @param  string $column
     * @param  array|string|number $value
     * @return void
     */
    public function scopeWhereInValue($query,$column,$value){
        if(!is_array($value)){
            $value=[$value];
        }        
        return $query->whereIn($column,$value);
    }

}
