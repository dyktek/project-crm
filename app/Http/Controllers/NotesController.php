<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NoteCreateRequest;
use App\Http\Requests\NoteUpdateRequest;
use App\Repositories\NoteRepository;
use App\Validators\NoteValidator;

/**
 * Class NotesController.
 *
 * @package namespace App\Http\Controllers;
 */
class NotesController extends Controller
{
    /**
     * @var NoteRepository
     */
    protected $repository;

    /**
     * @var NoteValidator
     */
    protected $validator;

    /**
     * NotesController constructor.
     *
     * @param NoteRepository $repository
     * @param NoteValidator $validator
     */
    public function __construct(NoteRepository $repository, NoteValidator $validator)
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
        $notes = $this->repository->all();


        return response()->json([
            'data' => $notes,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NoteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NoteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $note = $this->repository->create($request->all());

            $response = [
                'message' => 'Note created.',
                'data'    => $note->toArray(),
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
        $note = $this->repository->find($id);

        return response()->json([
            'data' => $note,
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
        $note = $this->repository->find($id);

        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NoteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NoteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $note = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Note updated.',
                'data'    => $note->toArray(),
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
            'message' => 'Note deleted.',
            'deleted' => $deleted,
        ]);
    }
}
