<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\GamesResource;
use App\Models\Games\Game;
use App\Repositories\Backend\Games\GamesRepository;
use Illuminate\Http\Request;
use Validator;

class GamesController extends APIController
{
    protected $repository;

    /**
     * __construct.
     *
     * @param $repository
     */
    public function __construct(GamesRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Do game move.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function doMove(Request $request)
    {
        $validation = $this->validateBlog($request);

        if ($validation->fails()) {
            return $this->throwValidation($validation->messages()->first());
        }

        $result = $this->repository->makeMove($request->all());

        return new GamesResource($result);
    }
}
