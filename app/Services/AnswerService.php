<?php
namespace App\Services;
use App\Answer;
use Spatie\Period\Period;
use Spatie\Period\PeriodCollection;

class AnswerService
{
    public function createAnswer($data, $person, $event)
    {

        $answers = $person->answers()->get();
        $newAnswerPeriod = Period::make($data['from'], $data['to']);
        $answersLength= $answers->count();
        $isOverlapping = false;
        $merged = false;

        for($i = 0; $i < $answersLength; $i++){
            $answerPeriod = Period::make($answers[$i]['from'], $answers[$i]['to']);
            if($answerPeriod->overlapsWith($newAnswerPeriod)){
                $isOverlapping = true;
                break;
            }
            if($answerPeriod->touchesWith($newAnswerPeriod)){
                $updatedFrom = min([$answers[$i]['from'], $data['from']]);
                $updatedTo = max([$answers[$i]['to'], $data['to']]);
                $answers[$i]->update([
                    'from' => $updatedFrom,
                    'to' => $updatedTo
                ]);
                $merged = true;
                break;
            }
        }
        
        $answer = null;
        if (!$merged && !$isOverlapping){
            $answer = Answer::create([
                'from' => $data['from'],
                'to' => $data['to'],
                'event_id' => $event->id,
                'person_id' => $person->id,
            ]);
        }
        
        return array($answer, $isOverlapping, $merged);
    }

    public function getAnswerById($id)
    {
        return Answer::where('id', '=', $id)->first(); 
    }

}