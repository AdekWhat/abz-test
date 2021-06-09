<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use \App\Models\Employees;
use \App\Models\Positions;
use Intervention\Image\Facades\Image;
use Arr;
use Propaganistas\LaravelPhone\PhoneNumber;
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
       'position' => 'required|exists:positions,name',
       'employment_date' => 'required|before:today|after:1980-01-01',
       'phone_number' => 'required|phone:UA',
       'email' => 'required|email',
       'salary' => 'required|int|max:500000',
       'image' => 'sometimes|mimes:jpg,png|max:5000|dimensions:min_width=300,min_height=300',
       'head' => 'exists:employees,full_name',

        ]);

        $position = Positions::where('name', $request->position)->first();
        $head = Employees::where('full_name', $request->head)->first();
        $E164_phone =  PhoneNumber::make($request->phone_number, 'UA' )->formatE164();

        if ($head->hierarchy == 5)
            return response()->json(["message" => "The given data was invalid.","errors" => ["head" => ["Employee that you choose not qualified"]]], 422);


        $dataToUpdate = [
        'full_name' => $request->full_name,
        'position' => $position->id,
         'employment_date' => $request->employment_date,
         'phone_number' => $E164_phone,
         'email' => $request->email,
         'salary' => $request->salary,
         'head_id' => $head->id,
         'hierarchy' => $head->hierarchy + 1

       ];

        if ($request->image) {
        $url = Storage::put('public/avatars', $request->image);
        $imagePath = str_replace("public", "storage", $url );
        $image = Image::make(public_path("{$imagePath}"))->fit(300, 300);
        $image = $image->orientate(); // exif orientation
        $image->save();

        $dataToUpdate['image_url'] = $imagePath;

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
         $employees = Employees::orderby('full_name')->select('id','full_name')->where('hierarchy','<', 5)->limit(5)->get();
      }else{
         $employees = Employees::orderby('full_name')->select('id','full_name')->where('full_name', 'like', '%' .$search . '%' )->where('hierarchy','<', 5)->limit(5)->get();
      }
      $response = array();
      foreach($employees as $employee){
         $response[] = array("value"=>$employee->id,"label"=>$employee->full_name);
      }

      return response()->json($response);



    }



}
