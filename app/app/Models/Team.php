<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function add($users)
    {
        // guard
        $this->guardAgainstTooManyMembers($this->extractNewUserCount($users));

        $method = $users instanceof User ? 'save' : 'saveMany';

        $this->members()->$method($users);  
    }

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function count()
    {
        return $this->members()->count();
    }

    public function remove($users = null)
    {
        if ($users instanceof User) {
            //$this->members()->where('user_id', $user->id)->delete();
            return $users->leaveTeam();
        }

        return $this->removeMany($users);
    }
    
    public function removeMany($users)
    {
        return $this->members()
                    ->whereIn('id', $users->pluck('id'))
                    ->update(['team_id' => null]);
    }

    public function restart()
    {
        return $this->members()->update(['team_id' => null]);
    }

    public function maximumSize()
    {
        return $this->size;
    }

    protected function guardAgainstTooManyMembers($newUsersCount)
    {
        

        $newTeamCount = $this->count() + $newUsersCount;

        if ($newTeamCount > $this->maximumSize()) {
            throw new \Exception;
        }
    }

    protected function extractNewUserCount($users)
    {
        return ($users instanceof User) ? 1 : count($users);
    }
}
