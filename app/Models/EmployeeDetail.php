<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDetail extends Model
{
    use HasFactory;
    protected $table = 'employee_details';
    protected $fillable = [
        'employee_id',
        'designation',
        'salary',
        'address',
        'joined_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
