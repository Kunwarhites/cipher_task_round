<?php

namespace App\Http\Controllers;

use App\Helpers\CryptoHelper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transactions = Auth::user()->transactions;
            return response()->json($transactions);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch transactions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

           
    
            $transaction = Transaction::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'message' => 'Transaction created successfully',
                'transaction' => $transaction
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            return response()->json($transaction);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to fetch transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);

            $request->validate([
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
            ]);

            $transaction->update($request->all());

            return response()->json([
                'message' => 'Transaction updated successfully',
                'transaction' => $transaction
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = Transaction::where('user_id', Auth::id())->findOrFail($id);
            $transaction->delete();

            return response()->json([
                'message' => 'Transaction deleted successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete transaction',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
