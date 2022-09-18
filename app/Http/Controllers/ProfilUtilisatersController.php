<?php

namespace App\Http\Controllers;

use App\Models\t_profils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilUtilisatersController extends Controller
{
    public function index(){
        $liste_profil = t_profils::orderBy('r_libelle', 'ASC')
        ->select('t_profils.r_i as value','t_profils.r_libelle as label')
        ->get();
        $datas = [
            '_status' => 1,
            '_result' => $liste_profil
        ];
        return $datas;
    }

    public function store(Request $request){

        $inputs = $request->all();//Récupère tous champs du formulaire

        $errors = [
            'r_libelle' => 'required|unique:t_profils'
        ];

        $erreurs = [
            'r_libelle.required' => 'Le libellé du profil est réquis',
            'r_libelle.unique' => 'Le libellé du profil existe dans la base'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{

            $insertion = t_profils::create(
                        [
                        'r_code_profil' => $request->p_code_profil,
                        'r_libelle'     => $request->r_libelle,
                        'r_description' => $request->p_description,
                        'r_status'      => 1
                        ]
                    );

            if($lastInsertedId = $insertion->r_i){
                $data = [
                    'status'=>1,
                    'msg'=>'Profil enregistré avec succès'
                ];
            }else{
                $data = [
                    'status'=>0,
                    'msg'=>'Une erreur est survenue lors de l\'enregistrement, veuillez contacter l\'éditeur'
                ];
            }
            return response()->json($data, 200);

        }
    }

public function test(Request $request){
    die($request->all());
}

    public function modif(Request $request, $id){
        $inputs = $request->all();//Récupère tous champs du formulaire
        //Validation des données
        $errors = [
            'r_libelle' => 'required'
        ];

        $erreurs = [
            'r_libelle.required' => 'Le libellé du profil est obligatoire'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{
            $update = t_profils::find($id);

            $update->update([
                'r_code_profil' => $request->p_code_profil,
                'r_libelle'     => $request->r_libelle,
                'r_description' => $request->p_description,
                'r_status'      => $request->p_status,
            ]);

            if( $update ){
                $responseData = [
                    "status" => 1,
                    "result" => "Modification éffectuée avec succes !",
                ];

                return response()->json($responseData, 200);
            }
        }
    }
}
