<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TokenLog;
use App\Models\Collaborator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokensLogs = TokenLog::orderBy('created_at', 'DESC')->get();
        $collaborators = Collaborator::all();


        return view('tokens.index')->with('tokensLogs', $tokensLogs)->with('collaborators', $collaborators);
    }


    public function tokensOfCollaborator()
    {
        $userAuthenticatedId = Auth::id();

        $tokensLogs = TokenLog::where('user_id', $userAuthenticatedId)
            ->orderBy('created_at', 'DESC') // 'DESC' debe estar como segundo parámetro
            ->get();
        return view('collaborators.tokens.index')->with('tokensLogs', $tokensLogs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collaborator_id' => 'required|exists:collaborators,id',
            'tokens' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.tokens')
                ->withErrors($validator)
                ->withInput();
        }

        $collaborator_id = $request->input('collaborator_id');
        $quantityTokensToAdd = $request->input('tokens');
        $description = $request->input('description');

        try {
            DB::transaction(function () use ($collaborator_id, $quantityTokensToAdd, $description) {
                TokenLog::create([
                    'user_id' => $collaborator_id,
                    'tokens' => $quantityTokensToAdd,
                    'description' => $description,
                    'type' => 'addition'
                ]);

                $collaborator = Collaborator::findOrFail($collaborator_id);
                $collaborator->tokens += $quantityTokensToAdd;
                $collaborator->save(); // Guarda los cambios
            });

            // Redirigir con éxito
            return redirect()->route('admin.tokens')
                ->with('success', 'Tokens añadidos correctamente.');
        } catch (\Exception $e) {
            // Redirigir con un mensaje de error
            return redirect()->route('admin.tokens')
                ->with('error', 'Error al añadir tokens: ' . $e->getMessage());
        }
    }

    public function remove(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'collaborator_id' => 'required|exists:collaborators,id',
            'tokens' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.tokens')
                ->withErrors($validator)
                ->withInput();
        }

        $collaborator_id = $request->input('collaborator_id');
        $quantityTokensToRemove = $request->input('tokens');
        $description = $request->input('description');

        try {
            DB::transaction(function () use ($collaborator_id, $quantityTokensToRemove, $description) {
                $collaborator = Collaborator::findOrFail($collaborator_id);

                if ($collaborator->tokens < $quantityTokensToRemove) {
                    throw new \Exception('El colaborador no tiene suficientes tokens para remover.');
                }

                TokenLog::create([
                    'user_id' => $collaborator_id,
                    'tokens' => -$quantityTokensToRemove, // Guardamos como negativo para dejarlo registrado
                    'description' => $description,
                    'type' => 'deduction'
                ]);

                $collaborator->tokens -= $quantityTokensToRemove;
                $collaborator->save();
            });

            return redirect()->route('admin.tokens')
                ->with('success', 'Tokens removidos correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.tokens')
                ->with('error', 'Error al remover tokens: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
