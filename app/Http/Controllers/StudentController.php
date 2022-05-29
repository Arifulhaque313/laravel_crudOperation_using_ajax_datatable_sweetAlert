<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{

    public function index(){
        return view('student.index');
    }


    public function fetchStudent(){
        $students = student::get();
        return response()->json([
            'students'=>$students,
        ]);
    }


    // store data 
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }

        else{
          $student = new student;
          $student->name=$request->input('name');
          $student->email=$request->input('email');
          $student->phone=$request->input('mobile');
          $student->password=$request->input('password');
          $student->save();

          return response()->json([
            'status'=>200,
            'message'=>"Student added Successfully",
          ]);

        }
    }


    public function edit(Request $request){
        $id = $request->id; 
        $student = student::find($id);

        if($student){
            return response()->json([
                'status' => 200,
                'student'=>$student,
            ]);
        }
        else{
            {
                return response()->json([
                    'status' => 404,
                    'student'=>"Student are not found",
                ]);
            }
        }
    }

    // update 
    public function update(Request $request){
        $id = $request->id;

        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'mobile'=>'required',
            'password'=>'required'
        ]);


        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }

        else{
          $student = student::find($id);
          if($student){
            $student->name=$request->input('name');
            $student->email=$request->input('email');
            $student->phone=$request->input('mobile');
            $student->password=$request->input('password');
            $student->update();

          return response()->json([
            'status'=>200,
            'message'=>"Student updated Successfully",
          ]);
        }

        else{
            {
                return response()->json([
                    'status' => 404,
                    'student'=>"Student are not found",
                ]);
            }
        }
        }
    }


    // destory class 
    public function destroy(Request $request){
        $id = $request->id;
        $studentData = student::find($id)->delete();

        if($studentData){
            return response()->json([
                'status'=>200,
                'message'=>"Student Delete Successfully",
              ]);
        }

        else{
            return response()->json([
                'status' => 404,
                'message'=>"There are some error",
            ]);
        }


       


    }




   
}
