<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class utilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listeUtilisateurs = DB::table('t_utilisateurs')
                                ->join('t_personnels', 't_personnels.r_i','=','t_utilisateurs.r_personnel')
                                ->join('t_profils', 't_profils.r_i','=','t_utilisateurs.r_profil')
                                ->select('t_utilisateurs.r_i','t_utilisateurs.r_login','t_utilisateurs.r_status',
                                't_personnels.r_nom','t_personnels.r_prenoms','t_profils.r_code_profil','t_profils.r_libelle as profil')
                                ->get();
        $datas = [
            '_status'   => 1,
            '_result'   => $listeUtilisateurs
        ];
        return response()->json($datas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_personnel'  => 'required',
            'r_login'  => 'required|min:4|unique:t_utilisateurs',
            'password'  => 'required|min:4|confirmed'
        ];

        $erreurs = [
            'p_personnel.required'  => 'Le profil est réquis',
            'r_login.required'  => 'L\'identifiant est obligatoire',
            'r_login.min'       => 'L\'identifiant doit avoir au minimum 4 caractères',
            'r_login.unique'       => 'Login déjà existant',
            'password.required' => 'Le mot de passe est réquis',
            'password.min' => 'Le mot de passe doit être de 4 caractères minimum',
            'password_confirmation.required' => 'Confirmer le mot de passe',
            'password.confirmed' => 'Les mots de passes ne correspondent pas',
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);



        if( $validate->fails() ){
            return $validate->errors();
        }else{

            $insertion = Utilisateurs::create([
                'r_personnel' => $request->p_personnel,
                'r_profil' => $request->p_profil,
                'r_utilisateur' => $request->p_utilisateur,
                'r_login' => $request->r_login,
                'password' => bcrypt($request->password),
                'r_status'  => 1,
            ]);
            $response = [
                '_status' => 1,
                '_result' => 'L\'utilisateur à bien été enregistré(e)',
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function show(rc $rc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function edit(rc $rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_profil'  => 'required',
            'p_nom'  => 'required|between:2,20',
            'p_prenoms'  => 'required|between:2,30',
            'r_telephone'  => 'required|unique:t_utilisateurs'
        ];

        $erreurs = [
            'p_profil.required'  => 'Le profil est réquis',
            'p_nom.required'  => 'Le nom est réquis',
            'p_nom.between'  => 'La taille du nom est compris entre 2 et 20 caractères',
            'p_prenoms.required'  => 'le nom est réquis',
            'p_prenoms.between'  => 'La taille du nom est compris entre 2 et 20 caractères',
            'r_telephone.required'  => 'Le numéro de téléphone est réquis',
            'r_telephone.unique'  => 'Le numéro de téléphone existe déjà',
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{
            $utilisateur = Utilisateurs::find($id);
            $utilisateur->update([
                'r_profil' => $request->p_profil,
                'r_nom' => $request->p_nom,
                'r_prenoms'=>   $request->p_prenoms,
                'r_telephone'   => $request->r_telephone,
                'r_status'  => 1,
            ]);

            $response = [
                '_status' => 1,
                '_result' => 'Modification effectuée avec succès',
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function destroy(rc $rc)
    {
        //
    }
}
