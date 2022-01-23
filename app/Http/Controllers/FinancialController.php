<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;

use App\Exceptions\Account\AccountNotFoundException;
use App\Exceptions\Transaction\CannotRollbackTransactionException;
use App\Exceptions\Transaction\TransactionNotFoundException;
use App\Exceptions\Transfer\CannotCreateNewTransferException;
use App\Exceptions\User\UserNotFoundException;

use App\Repositories\User\UserInterface;
use App\Repositories\Financial\AccountInterface;
use App\Repositories\Financial\AccountRepository;
use App\Repositories\Financial\TransactionInterface;

use App\Http\Requests\Financial\Account\NewTransferRequest;
use App\Http\Requests\Financial\Transaction\RollbackTransactionRequest;

use App\Jobs\Financial\ExecuteTransferenceJob;
use App\Jobs\Financial\RollbackTransferenceJob;

use App\Models\Financial\Transaction;

class FinancialController extends Controller
{

    /**
     * User Repository Interface
     *
     * @var UserInterface $user
     */
    protected UserInterface $user;

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
    public function __construct(UserInterface $user, AccountInterface $account, TransactionInterface $transaction)
    {
        $this->user = $user;
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
            return response()->json(
                auth()->user()->account->makeVisible(['balance_value'])
            );
        } catch (\Exception $error) {
            throw new AccountNotFoundException($error);
        }
    }

    /**
     * Return all transactions of the account of authenticated user
     *
     * @return JsonResponse
     */
    public function transactions(): JsonResponse
    {
        try {
            return response()->json([
                'payments' => auth()->user()->account->payments,
                'receipts' => auth()->user()->account->receipts
            ]);
        } catch (\Exception $error) {
            throw new AccountNotFoundException($error);
        }
    }

    /**
     * Create a new transference
     *
     * @param NewTransferRequest $request
     * @return JsonResponse
     * @throws CannotCreateNewTransferException|UserNotFoundException
     */
    public function newTransference(NewTransferRequest $request)
    {
        try {

            DB::beginTransaction();

            if (!in_array($request->input('type'), ['email', 'cpf', 'cnpj']))
                throw new CannotCreateNewTransferException(null, 'Tipo inválido', 400);

            if (!$payeeUser = $this->user->where([
                strtolower($request->input('type')) => $request->input('to')
            ])->first())
                throw new UserNotFoundException();

            $payerAccount = auth()->user()->account;
            $payeeAccount = $payeeUser->account;

            /**
             * @var Transaction $transaction
             */
            $transaction = $this->transaction->create([
                'payer_account_id' => $payerAccount->id,
                'payee_account_id' => $payeeAccount->id,
                'amount' => AccountRepository::floatToData($request->input('amount')),
            ]);

            dispatch(new ExecuteTransferenceJob($transaction));

            DB::commit();

            return response()->json([]);
        } catch (\Exception $error) {
            DB::rollback();
            throw new CannotCreateNewTransferException($error);
        }
    }

    /**
     * Rollback specific transaction of authenticated user
     *
     * @return JsonResponse
     * @throws CannotRollbackTransactionException|TransactionNotFoundException
     */
    public function rollbackTransaction(RollbackTransactionRequest $request): JsonResponse
    {
        try {

            if (!$transaction = $this->transaction->find($request->input('id')))
                throw new TransactionNotFoundException();

            dispatch(new RollbackTransferenceJob($transaction));

            return response()->json([]);
        } catch (\Exception $error) {
            throw new CannotRollbackTransactionException($error);
        }
    }

}
