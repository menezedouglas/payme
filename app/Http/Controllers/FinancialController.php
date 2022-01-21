<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Repositories\Financial\{
    AccountInterface,
    TransactionInterface
};

use App\Exceptions\Account\{
    NotFoundException,
    CannotDeleteException
};

use App\Exceptions\Transfer\{
    CannotCreateNewTransferException
};

use App\Http\Requests\Auth\NewTransferRequest;

class FinancialController extends Controller
{

    /**
     * Account Repository Interface
     *
     * @var AccountInterface $account
     */
    protected AccountInterface $account;

    /**
     * Transaction Repository Interface
     *
     * @var TransactionInterface $transaction
     */
    protected TransactionInterface $transaction;

    /**
     * Constructor method
     *
     * @param AccountInterface $account
     */
    public function __construct(AccountInterface $account, TransactionInterface $transaction)
    {
        $this->account = $account;
        $this->transaction = $transaction;
    }

    /**
     * Return financial account details of authenticated user
     *
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function index(): JsonResponse
    {
        try {

            dd(auth()->user()->account);

            return response()->json(
            );
        } catch (\Exception $error) {
            throw new NotFoundException($error);
        }
    }

    public function newTransfer(NewTransferRequest $request)
    {
        try {

            dd($request->all(), 'aqui');

        } catch (\Exception $error) {
            throw new CannotCreateNewTransferException($error);
        }
    }

    /**
     * Exclude financial account of authenticated user
     *
     * @return JsonResponse
     * @throws CannotDeleteException
     */
    public function deleteAccount(): JsonResponse
    {
        try {
            auth()->user()->account->delete();

            return response()->json([]);
        } catch (\Exception $error) {
            throw new CannotDeleteException($error);
        }
    }
}
