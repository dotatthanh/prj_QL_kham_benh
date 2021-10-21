<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCertification extends Model
{
    use HasFactory;

    protected $fillable = [
    	'title',
    	'patient_id',
    	'consulting_room_id',
    	'user_id',
    	'date',
    	'code',
    	'status',
    	'conclude',
    	'treatment_guide',
    	'suggestion',
    	'number',
    	'total_money',
    	'type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultingRoom()
    {
        return $this->belongsTo(ConsultingRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
