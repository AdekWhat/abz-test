<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use \App\Models\Positions;
// use \App\Models\Positions;
use DataTables;



class PositionsController extends Controller
{
    public function index()
    {
        return view('positions');
    }


    public function getPositions(Request $request)
    {


        if ($request->ajax()) {
            $data = Positions::all();
            foreach ($data as $value){
              $value->position = $value->name;
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }

    public function Autocomplete(Request $request)
    {
        $search = $request->search;

        if($search == ''){
           $positions = Positions::orderby('name')->select('id','name')->limit(5)->get();
        }else{
           $positions = Positions::orderby('name')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($positions as $position){
           $response[] = array("value"=>$position->id,"label"=>$position->name);
        }

        return response()->json($response);

    }

  }
