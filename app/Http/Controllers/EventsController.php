<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;

class EventsController extends Controller
{
	protected $eventRepository;

	public function __construct(EventRepository $eventRepository)
	{
		$this->eventRepository = $eventRepository;
	}

	public function index(Request $request)
    {
	    $startDate = $request->get('start_date');
	    $endDate = $request->get('end_date');

	    return $this->eventRepository->getEvents($startDate, $endDate);
    }

	public function myEvents(Request $request, $userId, UserRepository $userRepository)
	{
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');

		return $userRepository->myEvents($startDate, $endDate, $userId);
	}

    public function store(Request $request)
    {
    	$startDate = $request->get('start_date');
    	$endDate = $request->get('end_date');

		if($this->eventRepository->check($startDate, $endDate)) {
			return response()->json(['status' => 'cant create event on date: ' . $startDate . ' ' . $endDate], 400);
		} else {

			$event = $this
						->eventRepository
						->createEvent($request->all(), $request->get('user_id'));

			return response()->json($event, 201);
		}
    }

    public function show(Event $event)
    {
	    return response()->json($event);
    }

	public function update(Request $request, $id)
	{
		$startDate = $request->get('start_date');
		$endDate = $request->get('end_date');

		if($this->eventRepository->check($startDate, $endDate, $id)) {
			return response()
				->json(['status' => 'cant create event on date: ' . $startDate . ' ' . $endDate], 400);
		} else {
			$event = $this
				->eventRepository
				->editEvent($request->all(), $id);

			return response()->json($event, 201);
		}
	}

    public function destroy(Event $event)
    {
	    $event->delete();
	    return response()->json([]);
    }
}
