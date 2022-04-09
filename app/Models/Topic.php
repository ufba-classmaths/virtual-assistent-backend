<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;


    protected $fillable = [
        "name",
        "topic_id"
    ];
    public function getTopics()
    {
        return $this->hasMany(Topic::class);
    }


    public function getQuestions(): Collection
    {
        return Question::where('topic_id', $this->id)->get();
    }
}
