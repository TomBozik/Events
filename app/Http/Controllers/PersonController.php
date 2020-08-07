<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PersonController extends Controller
{

    protected $eventService;
    protected $personService;

    public function __construct(EventService $eventService, PersonService $personService)
    {
        $this->eventService = $eventService;
        $this->personService = $personService;
    }

    public function register(Request $request)
    {
        $data = request()->validate([
            'event_id' => ['required'],
            'person_name' => ['required'],
            'event_password' => ['required'],
            'email' => ['email', 'nullable'],
        ]);

        $event = $this->eventService->getEventById($data['event_id']);

        if ($data['event_password'] != $event->password) {
            throw ValidationException::withMessages(['event_password' => 'Wrong Event Password']);
        }

        $person = $this->personService->createPerson($data, $event);
        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])
            ->with('personCode', $person->code)
            ->withCookie($cookie);
    }

    public function showLoginForm(Request $request, $code)
    {
        $event = $this->eventService->getEventByCode($code);

        if ($event == null) {
            return redirect('/')->with('msg', 'Wrong Event Code!');
        }

        return view('persons.login', compact('event'));

    }

    public function login(Request $request)
    {
        $data = request()->validate([
            'event_id' => ['required'],
            'code' => ['required'],
        ]);

        $event = $this->eventService->getEventById($data['event_id']);
        $person = $this->personService->getPersonByCode($data['code']);

        if ($person == null) {
            throw ValidationException::withMessages(['code' => 'Wrong Code!']);
        }

        if ($person->event_id != $event->id) {
            throw ValidationException::withMessages(['code' => 'Wrong Code!']);
        }

        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])->withCookie($cookie);

    }

    public function deletePerson(Request $request, $id)
    {
        $personCode = $request->cookie('personCode');

        $personDeleted = $this->personService->deletePerson($personCode, $id);

        if ($personDeleted) {
            return response()->json(['data' => 'ok']);
        }

        abort(response()->json(['error' => 'Not admin / Wrong person to delete'], 400));
    }

}
