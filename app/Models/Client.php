<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'client_address',
        'client_phone_no',
        'project_name',
        'project_type',
        'project_type_detail',
        'client_project_status',
        'total_amount',
        'amount_paid',
        'balance',
        'quotation_sent',
        'quotation_file',
        'quotation_status',
        'payment_method' ,
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}