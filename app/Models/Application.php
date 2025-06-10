<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

      protected $fillable = [
        'company',
        'position',
        'applied_at',
        'status',
        'notes',
        'redflag',
        'cv_path',
        'cover_letter_path',
      ];

      public static $statuses = [
        'palyazva',
        'interju',
        'ajanlat',
        'elutasitva',
        'visszajelzes_var',
    ];

    protected $casts = [
        'applied_at' => 'date',
        'redflag' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }

        public function statusChanges()
    {
        return $this->hasMany(ApplicationStatusChange::class);
    }

    public function applicationNotes()
    {
        return $this->hasMany(ApplicationNote::class);
    }

}
