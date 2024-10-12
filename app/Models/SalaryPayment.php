<?php

namespace App\Models;

use App\Models\Employee;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryPayment extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'user_id',
        'salary_date',
        'invoice',
        'employee_id',
        'basic_salary',
        'salary_reduction',
        'net_salary',
    ];

    // public static function Invoice()
    // {
    //     $ceck = SalaryPayment::all();
    //     if ($ceck->count() > 0) {
    //         $salary = SalaryPayment::orderBy('id', 'DESC')->first();
    //         $iteration = (int) substr($salary->invoice, -8, 8);
    //         $iteration++;
    //         $char = "PYS-";
    //         $number = $char  .  sprintf("%08s", $iteration);
    //     } else {
    //         $number = "PYS-"  . "00000001";
    //     }
    //     return $number;
    // }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
