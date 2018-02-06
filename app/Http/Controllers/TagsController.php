<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TagCreateRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Repositories\TagRepository;
use App\Validators\TagValidator;

/**
 * Class TagsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TagsController extends Controller
{
    /**
     * @var TagRepository
     */
    protected $repository;

    /**
     * @var TagValidator
     */
    protected $validator;

    /**
     * TagsController constructor.
     *
     * @param TagRepository $repository
     * @param TagValidator $validator
     */
    public function __construct(TagRepository $repository, TagValidator $validator)
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
        $tags = $this->repository->all();


        return response()->json([
            'data' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TagCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TagCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $tag = $this->repository->create($request->all());

            $response = [
                'message' => 'Tag created.',
                'data'    => $tag->toArray(),
            ];

			$tag->events()->attach($request->get('event_id'));

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
        $tag = $this->repository->find($id);

        return response()->json([
            'data' => $tag,
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
        $tag = $this->repository->find($id);

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TagUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TagUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $tag = $this->repository->update($request->all(), $id);

	        $tag->events()->sync($request->get('event_id'));

            $response = [
                'message' => 'Tag updated.',
                'data'    => $tag->toArray(),
            ];

            return response()->json($response);

        } catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessageBag()
            ]);;
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
            'message' => 'Tag deleted.',
            'deleted' => $deleted,
        ]);
    }
}
