<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\PersonService;
use App\Services\EventService;
use App\Services\AnswerService;
use App\Http\Resources\AnswerResource;


class AnswerController extends Controller
{

    public function getMyAnswers(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $personService = new PersonService();

        $person = $personService->getPersonByCode($personCode);
        $answers = $person->answers()->get();

        return AnswerResource::collection($answers);
    }


    public function store(Request $request)
    {
        $personCode = $request->cookie('personCode');

        $data = request()->validate([
            'from' => ['required'],
            'to' => ['required'],
        ]);

        $answerService = new AnswerService();
        $eventService = new EventService();
        $personService = new PersonService();

        $person = $personService->getPersonByCode($personCode);
        $event = $eventService->getEventById($person->event_id);
        list($answer, $isOverlapping, $merged) = $answerService->createAnswer($data, $person, $event);
        
        if ($answer){
            return new AnswerResource($answer);
        }
        else if($isOverlapping){
            abort(response()->json(['error' => 'Your dates are overlapping!'], 400));
        }
        else {
            return response()->json(['data' => 'merged']);
        }

    }

    public function deleteAnswer(Request $request, $id)
    {
        $personCode = $request->cookie('personCode');

        $personService = new PersonService();
        $answerService = new AnswerService();

        $person = $personService->getPersonByCode($personCode);
        $answer = $answerService->getAnswerById($id);

        if($answer->person_id != $person->id){
            abort(response()->json(['error' => 'Wrong owner'], 400));
        }

        $answer->delete();

        return response()->json(['data' => 'ok']);
    }
}
