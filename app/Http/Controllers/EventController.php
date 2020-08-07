<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Resources\PersonResource;
use App\Services\EventService;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class EventController extends Controller
{
    protected $eventService;
    protected $personService;

    public function __construct(EventService $eventService, PersonService $personService)
    {
        $this->eventService = $eventService;
        $this->personService = $personService;
    }

    // VIEWS

    public function create(Request $request)
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'event_name' => ['required'],
            'event_password' => ['required'],
            'person_name' => ['required'],
            'email' => ['email', 'nullable'],
        ]);

        list($event, $person) = $this->eventService->saveEvent($data);
        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])
            ->with('personCode', $person->code)
            ->withCookie($cookie);
    }

    public function show(Request $request, $code)
    {
        $personCode = $request->cookie('personCode');
        $person = $this->personService->getPersonByCode($personCode);
        $event = $this->eventService->getEventByCode($code);

        if ($event == null) {
            return redirect('/')->with('msg', 'Wrong Event Code!');
        }
        if ($person == null) {
            return view('persons.register', compact('event'));
        }
        if ($person->event_id != $event->id) {
            return view('persons.register', compact('event'));
        }

        $isAdmin = $this->personService->checkIfAdmin($event, $person);

        return view('events.show', compact('event', 'person', 'isAdmin'));
    }

    // API

    public function getEventPersons(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $eventPersons = $this->eventService->getEventPersons($personCode);
        return PersonResource::collection($eventPersons);
    }

    public function getEvent(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $event = $this->eventService->getEvent($personCode);
        return new EventResource($event);
    }

    public function updateEvent(Request $request)
    {
        $personCode = $request->cookie('personCode');

        $data = request()->validate([
            'name' => ['required'],
            'description' => [''],
        ]);

        $event = $this->eventService->updateEvent($personCode, $data);

        return new EventResource($event);
    }

    public function getEventOverlaps(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $overlaps = $this->eventService->getOverlaps($personCode);

        return response()->json(['data' => $overlaps]);
    }
}
