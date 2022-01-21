<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Repositories\User\UserInterface;

use App\Http\Requests\User\{
    StoreRequest
};

use App\Exceptions\User\{
    UserNotFoundException,
    CannotCreateUserException,
    CannotGetAllUsersException
};

class UserController extends Controller
{

    /**
     * A User Repository
     *
     * @return UserInterface
     */
    protected UserInterface $user;

    /**
     * Constructor Method
     *
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->middleware('auth:cliente,lojista', ['except' => 'store']);

        $this->user = $user;
    }

    /**
     * Return all registered users
     *
     * @return JsonResponse
     * @throws CannotGetAllUsersException
     */
    public function index(): JsonResponse
    {
        try {
            return response()->json(
                $this->user->all()
            );
        } catch (\Exception $error) {
            throw new CannotGetAllUsersException($error);
        }
    }

    /**
     * Create a new user
     *
     * @return JsonResponse
     * @throws CannotCreateUserException
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            if (!$this->user->create($request->all()))
                abort(500, 'Não foi possível cadastrar o usuário!');

            DB::commit();

            return response()->json([]);
        } catch (\Exception $error) {
            DB::rollBack();
            throw new CannotCreateUserException($error);
        }
    }

    /**
     * Show a specific user
     *
     * @param int $id
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function show(int $id): JsonResponse
    {
        try {
            if(!$user = $this->user->find($id))
                abort(404, 'Usuário não encontrado');

            return response()->json($user);
        } catch (\Exception $error) {
            throw new UserNotFoundException($error);
        }
    }

    /**
     * Edit a authenticated user
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit(int $id)
    {
        try {
            return response()->json([]);
        } catch (\Exception $error) {
            return response(['error' => $error->getMessage()], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function delete()
    {
        try {
            return response()->json([]);
        } catch (\Exception $error) {
            return response(['error' => $error->getMessage()], 500);
        }
    }
}
