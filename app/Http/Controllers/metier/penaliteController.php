<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\metier\Penalite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class penaliteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_mnt'  => 'required',
            'p_motif'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'p_mnt.required' =>'Veuillez saisir le montant',
            'p_motif.unique' =>'Veuillez saisir le motif de la pénalité',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>-100,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{

            $insertion = Penalite::create([
                'r_location' => $request->p_location,
                'r_mnt' => $request->p_mnt,
                'r_motif' => $request->p_motif,
                'r_utilisateur' => $request->p_utilisateur
            ]);

            $response = [
                '_status' => 1,
            '_result' => 'L\'enregistrement à bien été effectuée'
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($idlocation)
    {
        $listePenalite = Penalite::where('r_location',$idlocation)->get();

        try {
            if( count($listePenalite) >= 1 ){

                $response = [
                    '_status' => 1,
                    '_result' => $listePenalite
                ];
            }else{
                $response = [
                    '_status' => 0,
                    '_result' => $listePenalite
                ];
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
        return response()->json($response, 200);
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
    public function update(Request $request, $idlocation)
    {
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_mnt'  => 'required',
            'p_motif'  => 'required',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'p_mnt.required' =>'Veuillez saisir le montant',
            'p_motif.unique' =>'Veuillez saisir le motif de la pénalité',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>-100,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{
          $update = Penalite::find($idlocation);

          if( $update !== null ){

                $update->update([
                    'r_mnt' => $request->p_mnt,
                    'r_motif' => $request->p_motif,
                    'r_utilisateur' => $request->p_utilisateur
                ]);

                $response = [
                    '_status' => 1,
                    '_result' => 'Modification effectuée avec succès'
                ];

          }else{

                $response = [
                    '_status' => 0,
                    '_result' => 'Une erreur est survenue lors de l\'enregistrement'
                ];

          }

                return response()->json($response, 200);
        }
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
