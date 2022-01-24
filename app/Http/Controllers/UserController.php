<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Repositories\User\UserInterface;

use App\Http\Requests\User\{
    StoreRequest,
    UpdateRequest
};

use App\Exceptions\Exception;

use App\Exceptions\User\{
    UserNotFoundException,
    CannotCreateUserException,
    CannotGetAllUsersException,
    CannotEditUserException
};
use App\Models\User;

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
     * Show the authenticated or a specific user
     *
     * @param int|null $id
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function show(?int $id = null): JsonResponse
    {
        try {
            if (!$user = $this->getUser($id))
                throw new UserNotFoundException();

            return response()->json($user);
        } catch (\Exception $error) {
            throw new UserNotFoundException($error);
        }
    }

    /**
     * Edit the authenticated or a specified user
     *
     * @param int|null $id
     * @param UpdateRequest $request
     * @return JsonResponse
     * @throws CannotEditUserException|UserNotFoundException
     */
    public function edit(?int $id = null, UpdateRequest $request): JsonResponse
    {
        try {
            if (!$user = $this->getUser($id))
                throw new UserNotFoundException();

            if ($this->user->where([
                'email' => $request->input('email'),
                ['id', '<>', $user->id]
            ])->exists())
                throw new CannotEditUserException(null, 'O E-mail informado já está sendo utilizado', 400);

            if ($this->user->where([
                'cpf' => $request->input('cpf'),
                ['id', '<>', $user->id]
            ])->exists())
                throw new CannotEditUserException(null, 'O CPF informado já está sendo utilizado', 400);

            if ($request->input('cnpj')) {
                if ($this->user->where([
                    'cnpj' => $request->input('cnpj'),
                    ['id', '<>', $user->id]
                ])->exists())
                    throw new CannotEditUserException(null, 'O CNPJ informado já está sendo utilizado', 400);
            }

            if (!$this->user->update($request->all(), $user->id))
                throw new CannotEditUserException();

            return response()->json([]);
        } catch (Exception $error) {
            throw new CannotEditUserException($error);
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

    /**
     * Return user by id
     *
     * @param int|null $id
     * @return User|null
     */
    protected function getUser(?int $id): ?User
    {
        switch ($id) {
            case null:
                return $this
                ->user
                ->where(['id' => auth()->user()->id])
                ->with(['type'])
                ->first()
                ->makeVisible(['cpf', 'cnpj']);

            default:
                return $this->user->find($id);
        }
    }
}
