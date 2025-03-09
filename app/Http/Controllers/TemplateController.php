<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{

    private $imageController;

    public function __construct() {
        $this->imageController = new ImageController();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::get();
        $courses = Course::all();
        return view('admin.templates.index')->with('templates', $templates)->with('courses', $courses);
    }

    public function assignToCourse(){
        $courses = Course::all();
        $templates = Template::all();
        return view ('admin.templates.course_assign')->with('courses', $courses)->with('templates', $templates);
    }

    public function assignToCourseUpdate(Request $request)
    {
        // Validación de entrada
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id', // Verifica que el curso exista
            'template_id' => 'required|exists:templates,id', // Verifica que el template exista
        ]);
    
        try {
            // Buscar el curso por su ID
            $course = Course::findOrFail($validatedData['course_id']);
    
            // Actualizar el campo template_id
            $course->template_id = $validatedData['template_id'];
            $course->save();
    
            // Redirigir con un mensaje de éxito
            return redirect()
                ->route('admin.templates.index')
                ->with('success', 'El template fue asignado correctamente al curso.');
        } catch (\Exception $e) {
            // Manejo de errores y redirección con mensaje de error
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al asignar el template: ' . $e->getMessage());
        }
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de los campos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación para la imagen
            'qr_x' => 'required|numeric',
            'qr_y' => 'required|numeric',
            'alumn_name_x' => 'required|numeric',
            'alumn_name_y' => 'required|numeric',
            'alumn_finishCourseDate_x' => 'required|numeric',
            'alumn_finishCourseDate_y' => 'required|numeric',
            'alumn_courseName_x' => 'required|numeric',
            'alumn_courseName_y' => 'required|numeric',
        ]);
    
        try {
            // Almacenamiento de la imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = $request->file('image')->store('images'); 
            }
    
            // Creación del template
            $template = new Template();
            $template->name = $request->input('name');
            $template->template_image_path = $imagePath ?? ''; 
            $template->qr_x = $request->input('qr_x');
            $template->qr_y = $request->input('qr_y');
            $template->alumn_name_x = $request->input('alumn_name_x');
            $template->alumn_name_y = $request->input('alumn_name_y');
            $template->alumn_finishCourseDate_x = $request->input('alumn_finishCourseDate_x');
            $template->alumn_finishCourseDate_y = $request->input('alumn_finishCourseDate_y');
            $template->alumn_courseName_x = $request->input('alumn_courseName_x');
            $template->alumn_courseName_y = $request->input('alumn_courseName_y');
            $template->save();
    
            // Retorno al índice de templates con un mensaje de éxito
            return redirect()->route('admin.templates.index')->with('success', 'Template creado exitosamente.');
    
        } catch (\Exception $e) {
            // Si ocurre un error, retornamos el mensaje de error
            return back()->withErrors(['error' => 'Hubo un error al crear el template. Por favor, inténtalo de nuevo.'])->withInput();
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function previewTemplate($templateId){
        $template = Template::find($templateId);
        
        $certifyCode = $this->generateCertifyCode(
            "Example",
            10,
            1,
            1,
            1,
            "2024-11-23"
        );

        $imagePath = $this->imageController->generateCertifyPDF(
            $template,
            $certifyCode,
            "LUISA VALERIA GONZALEZ JIMENEZ",
            "2024-11-23",
            "Curso de ejemplo para previsualizacion"
        );

        return response()->file($imagePath, [
            'Content-Type' => 'image',
            'Content-Disposition' => 'inline; filename="certificado.png"'
        ]);
    }

    public function generateCertifyCode($courseName, $courseHourLoad, $collaboratorId, $alumnId, $certifyId, $certifyAt)
    {
        // Extraer las primeras tres letras del nombre del curso y hacerlas mayúsculas
        $courseCode = strtoupper(substr($courseName, 0, 3));

        // Formatear la fecha de certificación para usarla en el código (ejemplo: YYYYMMDD)
        $dateCode = date('md', strtotime($certifyAt));

        // Combinar los datos en un formato único
        $certifyCode = $courseCode . '' . $collaboratorId . '' . $alumnId . '' . $certifyId . '' . $dateCode;

        return $certifyCode;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $templateId)
    {
        $template = Template::find($templateId);
        return view('admin.templates.edit')->with('template', $template);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Validar los datos recibidos
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'template_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Imagen opcional
                'qr_x' => 'required|numeric',
                'qr_y' => 'required|numeric',
                'alumn_name_x' => 'required|numeric',
                'alumn_name_y' => 'required|numeric',
                'alumn_finishCourseDate_x' => 'required|numeric',
                'alumn_finishCourseDate_y' => 'required|numeric',
                'alumn_courseName_x' => 'required|numeric',
                'alumn_courseName_y' => 'required|numeric',
            ]);
    
            $id = $request->input('template_id');
            // Encontrar el template por ID
            $template = Template::findOrFail($id);
    
            // Verificar si se subió una nueva imagen
            if ($request->hasFile('template_image')) {
                $image = $request->file('template_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = $request->file('template_image')->store('images');
                $template->template_image_path = $imagePath; 
            }
    
    
            // Actualizar los demás campos
            $template->name = $validatedData['name'];
            $template->qr_x = $validatedData['qr_x'];
            $template->qr_y = $validatedData['qr_y'];
            $template->alumn_name_x = $validatedData['alumn_name_x'];
            $template->alumn_name_y = $validatedData['alumn_name_y'];
            $template->alumn_finishCourseDate_x = $validatedData['alumn_finishCourseDate_x'];
            $template->alumn_finishCourseDate_y = $validatedData['alumn_finishCourseDate_y'];
            $template->alumn_courseName_x = $validatedData['alumn_courseName_x'];
            $template->alumn_courseName_y = $validatedData['alumn_courseName_y'];
    
            // Guardar los cambios
            $template->save();
    
            // Redirigir con mensaje de éxito
            return redirect()
                ->route('admin.templates.edit', $id)
                ->with('success', 'Template actualizado correctamente.');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Retornar errores de validación
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Manejo de otros errores
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al actualizar el template: ' . $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
