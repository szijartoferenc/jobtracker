<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatusChange extends Model
{
    use HasFactory;

    protected $fillable = ['application_id', 'old_status', 'new_status', 'changed_at'];

    public $timestamps = false;

    protected $casts = [
        'changed_at' => 'datetime', // << EZ HIÁNYZOTT
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
