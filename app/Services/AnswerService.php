<?php
namespace App\Services;
use App\Answer;

class AnswerService
{
    public function createAnswer($data, $person, $event)
    {
        $answer = Answer::create([
            'from' => $data['from'],
            'to' => $data['to'],
            'event_id' => $event->id,
            'person_id' => $person->id,
        ]);
        
        return $answer;
    }

    public function getAnswerById($id)
    {
        return Answer::where('id', '=', $id)->first(); 
    }

}