<?php

namespace App\Http\Controllers;

use App\Models\Master\Shift;
use App\Models\Presensi\TotalPresensiDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PenjadwalanShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.penjadwalanshift.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $shift = Shift::all();
        $Pshift = null;
        $for = 0;
        return view('pages.penjadwalanshift.add',compact('for','shift','Pshift'));
        //
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PenjadwalanShiftController $Pshift)
    {
        $shift = Shift::all();
        $for = 1;
        return view('pages.penjadwalanshift.add',compact('for','shift','Pshift'));
        
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function DataTable(DataTables $dataTables)
    {
        
    }
}
