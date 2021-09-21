<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function add($user)
    {
        // guard
        $this->guardAgainstTooManyMembers();

        $method = $user instanceof User ? 'save' : 'saveMany';

        if ($user instanceof User) {
            return $this->members()->save($user);
        }

        $this->members()->$method($user);  
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    protected function guardAgainstTooManyMembers()
    {
        if ($this->count() >= $this->size) {
            throw new \Exception;
        }
    }

    
}
