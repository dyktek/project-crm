<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AttachmentCreateRequest;
use App\Http\Requests\AttachmentUpdateRequest;
use App\Repositories\AttachmentRepository;
use App\Validators\AttachmentValidator;

/**
 * Class AttachmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AttachmentsController extends Controller
{
    /**
     * @var AttachmentRepository
     */
    protected $repository;

    /**
     * @var AttachmentValidator
     */
    protected $validator;

    /**
     * AttachmentsController constructor.
     *
     * @param AttachmentRepository $repository
     * @param AttachmentValidator $validator
     */
    public function __construct(AttachmentRepository $repository, AttachmentValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $attachments = $this->repository->all();

        return response()->json([
            'data' => $attachments,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AttachmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AttachmentCreateRequest $request)
    {

//    	dd($request->all());
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $attachment = $this->repository->create([
            	'name' => $request->get('name', null),
	            'source' => Storage::disk('public')->put('', $request->file('source'))
            ]);

            $eventId = $request->get('event', false);
            if($eventId) {
            	$attachment->events()->attach($eventId);
            }

            $response = [
                'message' => 'Attachment created.',
                'data'    => $attachment->toArray(),
            ];


            return response()->json($response);

        } catch (ValidatorException $e) {

            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $attachment = $this->repository->find($id);

        return response()->json([
            'data' => $attachment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $attachment = $this->repository->find($id);

        return view('attachments.edit', compact('attachment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AttachmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AttachmentUpdateRequest $request, $id)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

	        $attachment = $this->repository->update([
		        'name' => $request->get('name', null),
		        'source' => Storage::disk('public')->put('', $request->file('source'))
	        ], $id);

	        $eventId = $request->get('event', false);
	        if($eventId) {
		        $attachment->events()->sync($eventId);
	        }

            $response = [
                'message' => 'Attachment updated.',
                'data'    => $attachment->toArray(),
            ];

            return response()->json($response);
        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'Attachment deleted.',
            'deleted' => $deleted,
        ]);

    }
}
