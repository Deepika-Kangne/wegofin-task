<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLoanDetails extends Model
{
    use HasFactory;
    protected $table = 'client_loan_details';
    protected $fillable = [
        'card_request_id', 'new_card_amount', 'previous_card_amount', 'amount_updated_by'
    ];
}