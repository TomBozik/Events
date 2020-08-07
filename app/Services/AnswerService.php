<?php
namespace App\Services;

use App\Event;
use App\Person;
use App\Answer;
use Spatie\Period\Period;

class AnswerService
{

    public function createAnswer($data, $personCode)
    {
        $person = Person::where('code', $personCode)->firstOrFail();
        $event = Event::where('id', $person->event_id)->firstOrFail();
        $personAnswers = $person->answers()->get();

        $newAnswerPeriod = Period::make($data['from'], $data['to']);
        $isOverlapping = false;
        $merged = false;

        for ($i = 0; $i < $personAnswers->count(); $i++) {

            $answerPeriod = Period::make($personAnswers[$i]['from'], $personAnswers[$i]['to']);
            if ($answerPeriod->overlapsWith($newAnswerPeriod)) {
                $isOverlapping = true;
                break;
            }

            if ($answerPeriod->touchesWith($newAnswerPeriod)) {
                $updatedFrom = min([$personAnswers[$i]['from'], $data['from']]);
                $updatedTo = max([$personAnswers[$i]['to'], $data['to']]);

                Answer::find($personAnswers[$i]['id'])->update([
                    'id' => $personAnswers[$i]['id'],
                    'from' => $updatedFrom,
                    'to' => $updatedTo,
                ]);
                
                $merged = true;
                break;
            }
        }

        if (!$merged && !$isOverlapping) {
            Answer::create([
                'from' => $data['from'],
                'to' => $data['to'],
                'event_id' => $event->id,
                'person_id' => $person->id,
            ]);

        }

        return $isOverlapping;
    }

    public function deleteAnswer($id, $personCode)
    {
        $person = Person::where('code', $personCode)->first();
        $answer = Answer::where('id', $id)->firstOrFail();

        if ($answer->person_id != $person->id) {
            abort(response()->json(['error' => 'Wrong owner'], 400));
        }

        $answer->delete();
    }
}
