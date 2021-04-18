<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use \App\Models\Employees;
use \App\Models\Positions;
use Arr;
// use \App\Models\Positions;
use DataTables;


class EmployeesController extends Controller
{
    public function index()
    {
        return view('employees');
    }


    public function getEmployees(Request $request)
    {


        if ($request->ajax()) {
            $data = Employees::employeesGet();

            // foreach ($data as $value){
            //   // $value->position = $value->name;
            //   $head_key = array_search($value->head_id, array_column($data, 'id'));
            //   $head_key = Arr::get($data, $head_key);
            //   $value->head_name = $head_key->full_name;
            //
            //
            //
            // }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    // $actionBtn = '<a href="javascript:void(0)"  class="td.editor-edit edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a> ';
                     $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
                     $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $id
     * @return \Illuminate\Http\Response
     */
    public function Edit($id)
    {
        $employee = Employees::findEmployee($id);
        return response()->json($employee[0]);
    }

    public function Store(Request $request)
     {


        $validated = $request->validate([
       'full_name' => 'required|string|min:2|max:255',
       'position' => 'required',
       'employment_date' => 'required|before:today|after:1980-01-01',
       'phone_number' => 'required',
       'email' => 'required|email',
       'salary' => 'required|int|max:500000',
       'image' => 'sometimes|mimes:jpg,png|max:5000',
        ]);

        $position = Positions::where('name', $request->position)->first();

        $dataToUpdate = [
        'full_name' => $request->full_name,
        'position' => $position->id,
         'employment_date' => $request->employment_date,
         'phone_number' => $request->phone_number,
         'email' => $request->email,
         'salary' => $request->salary,
       ];

        if ($request->image) {
        $url = Storage::put('public/avatars', $request->image);
        $dataToUpdate['image_url'] = str_replace("public", "storage", $url );
      }



         Employees::updateOrCreate(
                 ['id' => $request->employee_id],
                 $dataToUpdate
                 );

         return response()->json(['success'=>'Product saved successfully.']);
     }


     public function Delete($id)
     {
       Employees::find($id)->delete();

       return response()->json(['success'=>'Product deleted successfully.']);
     }


     /*
  AJAX request
  */
    public function Autocomplete (Request $request){
      $search = $request->search;


      if($search == ''){
         $employees = Employees::orderby('full_name')->select('id','full_name')->limit(5)->get();
      }else{
         $employees = Employees::orderby('full_name')->select('id','full_name')->where('full_name', 'like', '%' .$search . '%')->limit(5)->get();
      }

      $response = array();
      foreach($employees as $employee){
         $response[] = array("value"=>$employee->id,"label"=>$employee->full_name);
      }

      return response()->json($response);



    }



}
