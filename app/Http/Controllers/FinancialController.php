<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Repositories\Financial\{
    AccountInterface,
    TransactionInterface
};

use App\Exceptions\Account\{
    AccountNotFoundException,
    CannotDeleteException
};

use App\Exceptions\Transfer\{
    CannotCreateNewTransferException
};

use App\Http\Requests\Account\NewTransferRequest;

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
     * @throws AccountNotFoundException
     */
    public function index(): JsonResponse
    {
        try {

            $with = [];

            switch (auth()->user()->type->name) {
                case 'cliente': {
                    $with =['payments', 'receipts'];
                    break;
                }
                case 'lojista': {
                    $with = ['receipts'];
                }
            }

            return response()->json(
                auth()->user()->account()->with($with)->get()
            );

        } catch (\Exception $error) {
            throw new AccountNotFoundException($error);
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
     * @throws CannotDeleteException|AccountNotFoundException
     */
    public function deleteAccount(): JsonResponse
    {
        try {
            if(!$account = auth()->user()->account)
                throw new AccountNotFoundException();

            $this->account->delete($account->id);

            return response()->json([]);
        } catch (\Exception $error) {
            throw new CannotDeleteException($error);
        }
    }
}
