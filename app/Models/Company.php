<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Company
 */
class Company extends BaseModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'website',
        'logo',
    ];

    protected $guarded = [];

    
        
    /**
     * consult the list of employees associated with the company
     *
     * @return void
     */
    public function employees() {
        return $this->hasMany(Employee::class);
    }
   
    
    /**
     * It allows to establish an intelligent search according to a sent parameter
     *
     * @param  object $query
     * @param  string $filter
     * @return void
     */
    public function scopeSearch($query, $filter){
        return $query->where('name', 'like', '%'.$filter.'%')
                    ->orWhere('email', 'like', '%'.$filter.'%');
    }
    
}