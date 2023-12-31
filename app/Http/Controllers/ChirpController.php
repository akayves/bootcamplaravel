<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index',[
             'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //traitement du formulaire
        $validaded = $request->validate(['message' => 'required|string|max:255']);

        /**
         * permettre à l'utilisateur qui est connecté de pouvoir enregistrer la requete via une relation
         * qui nous allons créer plus tard
         */
        $request->user()->chirps()->create($validaded);

        //return la page index après enregistrement
        return redirect(route('chirps.index'));


    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        //on verifie si il est autorisé à modifier, puis on lui renvoie la page de modification
        $this->authorize('update', $chirp);

        return view ('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp) : RedirectResponse
    {
        //verifie si il est autorizé à modifier
         $this->authorize('update', $chirp);

         $validaded = $request->validate([
            'message' => 'required|string|max:255',
         ]);

         $chirp->update($validaded);

         return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp) : RedirectResponse
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
