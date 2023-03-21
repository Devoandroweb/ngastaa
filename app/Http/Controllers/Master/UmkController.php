<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Master\Payroll\Umk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UmkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.masterdata.datapayroll.gajiumk.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $umk = null;
        $kabupaten = Kabupaten::all();
        $for = 1;
        return view('pages.masterdata.datapayroll.gajiumk.add',compact('umk','for','kabupaten'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $rules = [
            'kode_umk' => 'required',
            'nama_umk' => 'required',
            'nominal' => 'required',
            'kode_kabupaten' => 'required',
            'tahun' => 'required',
        ];

        if (!request('id')) {
            $rules['kode_umk'] = 'required|unique:umk';
        }

        $data = request()->validate($rules);

        if (request('nominal')) {
            $data['nominal'] = number_to_sql($data['nominal']);
        }
        $cr = Umk::updateOrCreate(['id' => request('id')], $data);

        if ($cr) {
            return redirect(route('master.payroll.umk.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil!"
            ]);
        } else {
            return redirect(route('master.payroll.umk.index'))->with([
                'type' => 'error',
                'messages' => "Gagal!"
            ]);
        }
    }

    public function edit(Umk $umk)
    {
        
        $kabupaten = Kabupaten::all();
        $for = 1;
        return view('pages.masterdata.datapayroll.gajiumk.edit',compact('umk','for','kabupaten'));
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
    public function delete(Umk $umk)
    {
        $cr = $umk->delete();
        if ($cr) {
            return redirect(route('master.payroll.umk.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('master.payroll.umk.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }
    function json(){
        $data = Umk::all();
        return response()->json($data);
    }
    public function datatable(DataTables $dataTables)
    {
        $model = Umk::with('kabupaten');
        return $dataTables->of($model)
        
        ->addColumn('nominal', function ($row) {
            return  number_indo($row->nominal);
        })
        ->addColumn('kabupaten', function ($row) {
            return $row->kabupaten->name;
        })
        ->addColumn('opsi', function ($row) {

            $html = "<a class='me-2 edit' tooltip='Edit' href='" . route('master.payroll.umk.edit', $row->id) . "'>" . icons('pencil') . "</a>";
            $html .= "<a class='delete text-danger' tooltip='Hapus' href='" . route('master.payroll.umk.delete', $row->id) . "'>" . icons('trash') . "</a>";
            return $html;
        })
        ->rawColumns(['opsi','kabupaten'])
        ->addIndexColumn()
        ->toJson();
    }
}
