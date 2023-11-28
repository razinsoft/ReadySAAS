<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function customerGroup(){
        return $this->belongsTo(CustomerGroup::class,'customer_group_id');
    }
}
