<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Exceptions\User\UserNotFoundException;

class UserController extends Controller
{

    public function __construct()
    {
        // initialize
    }

    /**
     * @return JsonResponse
     */
    public function index ()
    {
        try {
            return response()->json([]);
        } catch (\Exception $error) {
            return response(['error' => $error->getMessage()], 500);
        }
    }

    /**
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function store (Request $request)
    {
        try {
            dd($request->all());
            return response()->json([]);
        } catch (\Exception $error) {
            dd($error);
            return response(['error' => $error->getMessage()], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    public function show ()
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
    public function edit ()
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
    public function delete ()
    {
        try {
            return response()->json([]);
        } catch (\Exception $error) {
            return response(['error' => $error->getMessage()], 500);
        }
    }


}
