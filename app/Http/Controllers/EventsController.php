<?php

namespace App\Http\Controllers;

use App\Entities\Event;
use App\Http\Requests\EventCreateRequest;
use App\Repositories\EventRepositoryEloquent;
use App\Validators\EventValidator;
use Illuminate\Http\Request;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Carbon;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class EventsController extends Controller
{
	/**
	 * @var EventRepositoryEloquent
	 */
	protected $eventRepository;

	/**
	 * @var RoleValidator
	 */
	protected $validator;

	public function __construct(EventRepository $eventRepository, EventValidator $validator)
	{
		$this->eventRepository = $eventRepository;
		$this->validator = $validator;
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

	/**
	 * @param EventCreateRequest $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(EventCreateRequest $request)
    {
	    try {
		    $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

		    $startDate = $request->get( 'start_date' );
		    $endDate   = $request->get( 'end_date' );

			$checkDate  = $this->checkDate($startDate, $endDate);
			if($checkDate['error']) {
				return response()->json($checkDate,400);
			}

		    if ($this->eventRepository->check($startDate, $endDate)) {
				$response = [
					'error' => true,
					'message' => 'cant create event on date: ' . $startDate . ' ' . $endDate
				];
			    return response()->json($response, 400);
		    } else {
			    $event = $this
				    ->eventRepository
				    ->createEvent($request->all(), $request->get('user_id'));
		    }

		    $response = [
		    	'message' => 'Event created',
			    'data' => $event
		    ];
		    return response()->json($response, 201);
	    } catch (ValidatorException $e) {
		    return response()->json([
			    'error'   => true,
			    'message' => $e->getMessageBag()
		    ]);
	    }
    }

    public function show(Event $event)
    {
	    return response()->json($event);
    }

	public function update(Request $request, $id)
	{
		try {
			$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

			$startDate = $request->get('start_date');
			$endDate = $request->get('end_date');

			$checkDate  = $this->checkDate($startDate, $endDate);
			if($checkDate['error']) {
				return response()->json($checkDate,400);
			}

			if($this->eventRepository->check($startDate, $endDate, $id)) {
				$response = [
					'error' => true,
					'message' => 'cant create event on date: ' . $startDate . ' ' . $endDate
				];
				return response()
					->json($response, 400);
			} else {
				$event = $this
					->eventRepository
					->editEvent($request->all(), $id);
				$response = [
					'message' => 'Event edited',
					'data' => $event
				];
				return response()->json($response, 200);
			}

		} catch (ValidatorException $e) {
			return response()->json([
				'error'   => true,
				'message' => $e->getMessageBag()
			]);
		}
	}

    public function destroy($id)
    {
	    $deleted = $this->eventRepository->delete($id);

	    return response()->json([
		    'message' => 'Event deleted.',
		    'deleted' => $deleted,
	    ]);
    }

    private function checkDate($startDate, $endDate)
    {
	    $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate);
	    $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDate);

	    if($startDate < $endDate) {

	    	$diff = $endDate->diffInMinutes($startDate);

	    	if($diff < 15) {
			    return [
				    'error' => true,
				    'message' => 'event must be at﻿ least 15 minutes long'
			    ];
		    }

		    return [
		    	'error' => false
		    ];
	    }

	    return [
	    	'error' => true,
		    'message' => 'start date have to be earlier than end date'
	    ];
    }
}
