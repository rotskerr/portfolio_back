<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Projects extends Model
{
    use HasFactory,AsSource;
    protected $guarded=['id'];
    protected $fillable=['path','name', 'text', 'URL'];
}
