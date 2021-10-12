<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Likeability;

class Post extends Model
{
    use Likeability;
    use HasFactory;


}
