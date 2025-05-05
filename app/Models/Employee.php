<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name', 'email', 'department_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (!$employee->id) {
                $employee->id = (string) Str::uuid();
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function detail()
    {
        return $this->hasOne(EmployeeDetail::class, 'employee_id', 'id');
    }
}
