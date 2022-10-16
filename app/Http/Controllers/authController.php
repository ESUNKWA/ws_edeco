<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use App\Models\isUserConnect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\ResponseTrait;

class authController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $errors = [
            'p_login' => 'required',
            'p_mdp' => 'required',
        ];
        $erreurs = [
            'p_login.required' => 'Veuillez saisir votre identifiant',
            'p_mdp.required' => 'Veuillez saisir votre mot de passe',
        ];

        $validate = Validator::make($request->all(), $errors, $erreurs);


        if( $validate->fails() ){
            return $validate->errors();
        }
        //Récuperation des infos des utilisateurs

        try {
             $login = Utilisateurs::join('t_personnels','t_personnels.r_i', '=','t_utilisateurs.r_personnel')
                               ->join('t_profils','t_profils.r_i', '=','t_utilisateurs.r_profil')
                               ->select('t_utilisateurs.r_i','t_utilisateurs.r_login','t_personnels.r_nom','t_personnels.r_prenoms','t_personnels.r_contact','t_profils.r_libelle as profil','t_profils.r_code_profil','t_utilisateurs.password')
                               ->where('r_login', '225'.$request->p_login)
                               ->first();

            if (!$login) {
                return $this->responseCatchError('Login ou Mot de passe incorrecte !');
            }

            // Vérifier si l'utilisateur est déjà connecté

            //$isUserConnect = isUserConnect::where('tokenable_id', $login->r_i)->first();

            //if( !$isUserConnect ){

                if( Hash::check($request->p_mdp, $login->password) ){

                    unset($login->password); // Suppression du mot de passe dans le retour de l'API

                    $token = $login->createToken('auth_token')->plainTextToken; // Création du token

                    $response = [
                        '_status' => 1,
                        '_result' => [$login],
                        '_access_token' => $token
                    ];
                    return response()->json($response, 200);
                }else{
                    $this->responseCatchError('Login ou Mot de passe incorrecte !');
                    //return response()->json(['_status'=>0, '_result'=>'Login ou Mot de passe incorrecte !']);
                }

            //}

            //return response()->json(['_status'=>0, '_result'=>'Utilisateur dejà connecté  !!!']);

        } catch (\Throwable $e) {
            return $e->getMessage();
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
    public function update(Request $request, rc $rc)
    {
        //
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

    public function deconnect(Request $request){

        try {
            //code...
            Utilisateurs::where('r_i', $request->p_id)->first()->tokens()->delete();

            return response()->json(['_status'=>1, '_result'=>'Vous êtes maintenant déconnecté !']);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }
}
