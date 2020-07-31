<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Http\Request;
use App\Services\PersonService;
use App\Services\EventService;
use Illuminate\Support\Facades\Crypt;
use App\Http\Resources\PersonResource;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function create(Request $request)
    {
        return view('events.create');
    }


    public function store(Request $request)
    {
        $data = request()->validate([
            'event_name'        => ['required'],
            'event_password'    => ['required'],
            'person_name'       => ['required'],
            'email'             => ['required'],
            // 'description'       => ['required'],
            // 'max_answers'       => ['required'],
        ]);
        

        $eventService = new EventService();
        $personService = new PersonService();

        $event = $eventService->createEvent($data);
        $person = $personService->createPerson($data, $event);

        $event = $eventService->addAdmin($event, $person);

        $cookie = cookie('personCode', $person->code, 525600);

        return redirect()->route('events.show', ['code' => $event->code])
                ->with('personCode', $person->code)
                ->withCookie($cookie);
    }


    public function show(Request $request, $code)
    {
        $eventService = new EventService();
        $personService = new PersonService();
        $event = $eventService->getEventByCode($code);

        if($event == null){
            return redirect('/')->with('msg', 'Wrong Event Code!');
        }

        $personCode = $request->cookie('personCode');
        if($personCode == null){
            return view('persons.register', compact('event'));
        } else {
            $person = $personService->getPersonByCode($personCode);
            if($person == null){
                return view('persons.register', compact('event'));
            }
            if($person->event_id != $event->id){
                return view('persons.register', compact('event'));
            }
        }

        $isAdmin = 0;
        if($person->id == $event->admin_id){
            $isAdmin = 1;
        }

        return view('events.show', compact('event', 'person', 'isAdmin'));
    }


    public function getEventPersons(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $eventService = new EventService();
        $personService = new PersonService();

        $person = $personService->getPersonByCode($personCode);
        $event = $eventService->getEventById($person->event_id);
        $eventPersons = $event->peoples()->get();

        return PersonResource::collection($eventPersons);
    }


    public function getEventInfo(Request $request)
    {
        $personCode = $request->cookie('personCode');
        $eventService = new EventService();
        $personService = new PersonService();

        $person = $personService->getPersonByCode($personCode);
        $event = $eventService->getEventById($person->event_id);

        return new EventResource($event);
    }


    public function updateEventInfo(Request $request)
    {
        $personCode = $request->cookie('personCode');

        $data = request()->validate([
            'name'           => ['required'],
            'description'    => [''],
        ]);

        $personService = new PersonService();
        $eventService = new EventService();

        $person = $personService->getPersonByCode($personCode);
        $event = $eventService->getEventById($person->event_id);

        if($event->admin_id != $person->id){
            abort(response()->json(['error' => 'Not Event Admin'], 400));
        }
        
        $event = $eventService->updateEvent($event, $data);
        return new EventResource($event);
    }
}
