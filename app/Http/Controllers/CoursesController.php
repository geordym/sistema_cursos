<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuthenticatedId = Auth::id();
        
        $courses = Course::orderBy('created_at', 'DESC')->where('collaborator_id', $userAuthenticatedId)->get();
        
        return view('collaborators.courses.index')->with('courses', $courses);
    }

    public function indexAdmin()
    {
        $courses = Course::orderBy('created_at', 'DESC')->get();
        
        return view('admin.courses.index')->with('courses', $courses);
    }

    public function editCertifyTemplate($courseId)
    {
        $course = Course::where('id', $courseId)->first();
        return view('admin.courses.edit_template')->with('course', $course);
    }

    public function storeCertifyTemplate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|image|max:1024', 
            'course_id' => 'required|integer|min:1',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $filePath = $request->file('image')->store('images'); 

        $course = Course::find($request->input('course_id'));
        $course->course_template = $filePath;
        $course->save();

        return $filePath;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('collaborators.courses.create');
    }

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        try {
            Course::create([
                'name' => $request->input('name'),
                'hour_load' => $request->input('duration'),
                'collaborator_id' => Auth::id(),
            ]);
    
            return redirect()->route('collaborators.courses.index')->with('success', 'Curso creado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el curso: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function showCertifyTest($courseId)
    {
        
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
