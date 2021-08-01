<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Employee
 */
class Employee extends BaseModel
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    protected $guarded = [];

    protected $appends = ['full_name'];  
    
    /**
     * Returns the full name of the employee
     *
     * @return void
     */
    public function getFullNameAttribute()
    {
    	return $this->first_name.' '.$this->last_name;
    }
        
    /**
     * Check the details of the company to which the employee belongs
     *
     * @return void
     */
    public function company() {
        return $this->belongsTo(Company::class);
    }
    
    
    /**
     * It allows to establish an intelligent search according to a sent parameter
     *
     * @param  object $query
     * @param  string $filter
     * @return void
     */
    public function scopeSearch($query, $filter){
        return $query->Where('id', $filter)
                    ->orWhere('first_name', 'like', '%'.$filter.'%')
                    ->orWhere('last_name', 'like', '%'.$filter.'%')
                    ->orWhere('email', 'like', '%'.$filter.'%')
                    ->orWhereHas('company',function($query) use($filter){
                        $query->where('name', 'like', '%'.$filter.'%');
                    });
    }
    
}