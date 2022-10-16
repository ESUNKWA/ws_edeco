<?php

namespace App\Http\Controllers\personnel;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\personnel\Personnel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class personnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listePersonnel = DB::table('t_personnels')
        ->join('t_fonctions', 't_fonctions.r_i','=','t_personnels.r_fonction')
        ->join('t_communes', 't_communes.r_i','=','t_personnels.r_quatier')
        ->select('t_personnels.*','t_communes.r_libelle as domicile','t_fonctions.r_libelle as fonction')
        ->whereNotIn('t_personnels.r_editeur', [1])
        ->get();
        $datas = [
        '_status'   => 1,
        '_result'   => $listePersonnel
        ];
        return response()->json($datas, 200);
    }

    public function listNotUser()
    {
        $listePersonnel = DB::table('t_personnels')
        ->leftJoin('t_utilisateurs', 't_personnels.r_i','=','t_utilisateurs.r_personnel')
        ->select('t_personnels.r_nom','t_personnels.r_prenoms','t_personnels.r_contact','t_personnels.r_i')
        ->where('t_utilisateurs.r_personnel', null)
        ->orderBy('t_personnels.r_i', 'ASC')
        ->get();
        $datas = [
        '_status'   => 1,
        '_result'   => $listePersonnel
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
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_nom'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'p_nom.required' =>'Le nom est obligatoire',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            return $validate->errors();
        }else{

            try {
                $insertion = Personnel::create([
                    'r_civilite' => $request->p_civilite,
                    'r_nom' => $request->p_nom,
                    'r_prenoms' => $request->p_prenoms,
                    'r_contact' => $request->p_contact,
                    'r_email' => $request->p_email,
                    'r_date_entree' => $request->p_date_entree,
                    'r_date_depart' => $request->p_date_depart,
                    'r_quatier' => $request->p_quatier,
                    'r_fonction' => $request->p_fonction,
                    'r_description' => $request->p_description,
                    'r_utilisateur' => $request->p_utilisateur,
                ]);

                $response = [
                    '_status' => 1,
                    '_result' => 'Enregistrement effectuée avec succès'
                ];
                return response()->json($response, 200);
            } catch (\Throwable $e) {
                return response()->json($e->getMessage(), 200);
            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(cr $cr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}
