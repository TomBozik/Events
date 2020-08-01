<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Services\PersonService;
use App\Services\EventService;

class PersonController extends Controller
{
    public function register(Request $request)
    {
        $data = request()->validate([
            'event_id'          => ['required'],
            'person_name'       => ['required'],
            'event_password'    => ['required'],
            'email'             => ['email', 'nullable'],
        ]);
        

        $eventService = new EventService();
        $personService = new PersonService();

        $event = $eventService->getEventById($data['event_id']);
        
        if($data['event_password'] != $event->password){
            throw ValidationException::withMessages(['event_password' => 'Wrong Event Password']);
        }

        $person = $personService->createPerson($data, $event);
        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])
                ->with('personCode', $person->code)
                ->withCookie($cookie);
    }


    public function showLoginForm(Request $request, $code)
    {
        $eventService = new EventService();
        $event = $eventService->getEventByCode($code);

        if($event == null){
            return redirect('/')->with('msg', 'Wrong Event Code!');
        }

        return view('persons.login', compact('event'));

    }

    public function login(Request $request)
    {
        $data = request()->validate([
            'event_id'          => ['required'],
            'code'              => ['required'],
        ]);

        $eventService = new EventService();
        $personService = new PersonService();
        $event = $eventService->getEventById($data['event_id']);
        $person = $personService->getPersonByCode($data['code']);

        if($person == null){
            throw ValidationException::withMessages(['code' => 'Wrong Code!']);
        }

        if($person->event_id != $event->id){
            throw ValidationException::withMessages(['code' => 'Wrong Code!']);
        }

        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])->withCookie($cookie);

    }


    public function deletePerson(Request $request, $id)
    {
        $personCode = $request->cookie('personCode');

        $personService = new PersonService();
        $eventService = new EventService();

        $person = $personService->getPersonByCode($personCode);
        $event = $eventService->getEventById($person->event_id);
        $personToDelete = $personService->getPersonById($id);

        if (($person->id == $event->admin_id) && ($personToDelete->event_id == $event->id) && ($personToDelete->id != $event->admin_id)){
            $personToDelete->answers()->delete();
            $personToDelete->delete();
            return response()->json(['data' => 'ok']);
        }

        abort(response()->json(['error' => 'Not admin / Wrong person to delete'], 400));

    }

}
