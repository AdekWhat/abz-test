<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use \App\Models\Employees;
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
            foreach ($data as $value){
              $value->position = $value->name;
            }
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function Edit($id)
    {
        $employee = Employees::findEmployee($id);
        return response()->json($employee[0]);
    }

    public function Store(Request $request)
     {

        //
        // if   ($request->image == "undefined"){
        //    // $request->image = File::get('storage/avatars/f8bhmaemsr8wnUJrZWUNyXj4eC8gt1BwzIrQMDaj.jpg');\
        //   $request->image = null;
        //    $request->position_id = 1;
        // }

        // dd($request);

        $validated = $request->validate([
       'full_name' => 'required|string|max:255',
       'position' => 'required',
       'employment_date' => 'required|before:today|after:1980-01-01',
       'phone_number' => 'required',
       'email' => 'required|email',
       'salary' => 'required|int|max:50000',
       'image' => 'mimes:jpg,png|max:1024|nullable',
        ]);


       //     $validated = $request->validate([
       // 'full_name' => 'required|max:255',
       // 'email' => 'required',
       //  ]);
        // $head
        if ($request->image) {
        $url = Storage::put('public/avatars', $request->image);
        }


         Employees::updateOrCreate(
                 ['id' => $request->employee_id],
                 ['full_name' => $request->full_name,
                 'position' => $request->position_id,
                  'employment_date' => $request->employment_date,
                  'phone_number' => $request->phone_number,
                  'email' => $request->email,
                  'image_url' => $url,
                  'salary' => $request->salary,
                ]);

         return response()->json(['success'=>'Product saved successfully.']);
     }


     public function Delete($id)
     {
       Employees::find($id)->delete();

       return response()->json(['success'=>'Product deleted successfully.']);
     }


}
