<?php

namespace App\Http\Controllers\location;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class detailsLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($idlocation)
    {
        $detailByLocation = DB::table('t_produits')
                                //->join('t_locations', 't_locations.r_i', 't_details_locations.r_location')
                                ->join('t_details_locations', 't_produits.r_i', 't_details_locations.r_produit')
                                //->join('t_tarifications', 't_produits.r_i', 't_tarifications.r_produit')
                                ->select('t_details_locations.*', 't_produits.r_libelle as lib_produit')
                                ->where('t_details_locations.r_location', $idlocation)
                                //->where('t_tarifications.r_es_utiliser', 1)
                                ->get();
        $response = [
                       '_status' => 1,
                        '_result' => $detailByLocation
                        ];
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
