<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Template;
use Illuminate\Http\Request;
use FPDF;

class TemplateController extends Controller
{

    private $imageController;

    public function __construct()
    {
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

    public function assignToCourse()
    {
        $courses = Course::all();
        $templates = Template::all();
        return view('admin.templates.course_assign')->with('courses', $courses)->with('templates', $templates);
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
            // Nuevos campos
            'alumn_name_text_size' => 'nullable|numeric', // Tamaño del texto Nombre Alumno
            'alumn_name_text_color' => 'nullable|string|max:7', // Color del texto Nombre Alumno
            'alumn_name_text_align' => 'nullable|string|max:20', // Alineación del texto Nombre Alumno
            'finish_course_text_size' => 'nullable|numeric', // Tamaño del texto Fecha Finalización
            'finish_course_text_color' => 'nullable|string|max:7', // Color del texto Fecha Finalización
            'finish_course_text_align' => 'nullable|string|max:20', // Alineación del texto Fecha Finalización
            'course_name_text_size' => 'nullable|numeric', // Tamaño del texto Nombre Curso
            'course_name_text_color' => 'nullable|string|max:7', // Color del texto Nombre Curso
            'course_name_text_align' => 'nullable|string|max:20', // Alineación del texto Nombre Curso
            'qr_size' => 'nullable|numeric',
            'page_orientation' => 'nullable|string|max:20',
            'page_width' => 'nullable|numeric',
            'page_height' => 'nullable|numeric'
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

            // Nuevos campos
            $template->alumn_name_text_size = $request->input('alumn_name_text_size');
            $template->alumn_name_text_color = $request->input('alumn_name_text_color');
            $template->alumn_name_text_align = $request->input('alumn_name_text_align');
            $template->finish_course_text_size = $request->input('finish_course_text_size');
            $template->finish_course_text_color = $request->input('finish_course_text_color');
            $template->finish_course_text_align = $request->input('finish_course_text_align');
            $template->course_name_text_size = $request->input('course_name_text_size');
            $template->course_name_text_color = $request->input('course_name_text_color');
            $template->course_name_text_align = $request->input('course_name_text_align');
            $template->qr_size = $request->input('qr_size');
            $template->page_orientation = $request->input('page_orientation');
            $template->page_width = $request->input('page_width');
            $template->page_height = $request->input('page_height');

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

    public function previewTemplate($templateId)
    {
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
            $certifyCode,
            "LUISA VALERIA GONZALEZ JIMENEZ",
            "2024-11-23",
            "Curso de ejemplo para previsualizacion"
        );


        $tempPdfPath = tempnam(sys_get_temp_dir(), 'pdf_') . '.pdf';
        $imageInPdf = $this->imageToPdf($imagePath, $tempPdfPath, $template);

        return response()->file($tempPdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificado.pdf"',
        ]);
    }

    function imageToPdf($imagePath, $pdfPath, $template)
    {

        $orientation = $template->page_orientation ?? "L";
        // Crear una instancia de FPDF con orientación horizontal ('L')
        $pdf = new FPDF($orientation, 'mm', 'A4');
        $pdf->AddPage();

        // Dimensiones de la página A4 en orientación horizontal (A4 landscape)
        $pageWidth = $template->page_width ?? 297;
        $pageHeight = $template->page_height ?? 210;

        // Insertar la imagen en el PDF para que ocupe toda la página
        $pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight);

        // Guardar el PDF en la ruta especificada
        $pdf->Output('F', $pdfPath);
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
                // Nuevos campos
                'alumn_name_text_size' => 'nullable|numeric', // Tamaño del texto Nombre Alumno
                'alumn_name_text_color' => 'nullable|string|max:7', // Color del texto Nombre Alumno
                'alumn_name_text_align' => 'nullable|string|max:20', // Alineación del texto Nombre Alumno
                'finish_course_text_size' => 'nullable|numeric', // Tamaño del texto Fecha Finalización
                'finish_course_text_color' => 'nullable|string|max:7', // Color del texto Fecha Finalización
                'finish_course_text_align' => 'nullable|string|max:20', // Alineación del texto Fecha Finalización
                'course_name_text_size' => 'nullable|numeric', // Tamaño del texto Nombre Curso
                'course_name_text_color' => 'nullable|string|max:7', // Color del texto Nombre Curso
                'course_name_text_align' => 'nullable|string|max:20', // Alineación del texto Nombre Curso
                'qr_size' => 'nullable|numeric', // Tamaño del texto Nombre Alumno
                'page_orientation' => 'nullable|string|max:20',
                'page_width' => 'nullable|numeric',
                'page_height' => 'nullable|numeric'
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

            // Nuevos campos
            $template->alumn_name_text_size = $validatedData['alumn_name_text_size'];
            $template->alumn_name_text_color = $validatedData['alumn_name_text_color'];
            $template->alumn_name_text_align = $validatedData['alumn_name_text_align'];
            $template->finish_course_text_size = $validatedData['finish_course_text_size'];
            $template->finish_course_text_color = $validatedData['finish_course_text_color'];
            $template->finish_course_text_align = $validatedData['finish_course_text_align'];
            $template->course_name_text_size = $validatedData['course_name_text_size'];
            $template->course_name_text_color = $validatedData['course_name_text_color'];
            $template->course_name_text_align = $validatedData['course_name_text_align'];
            $template->qr_size = $validatedData['qr_size'];
            $template->page_orientation = $validatedData['page_orientation'];
            $template->page_width = $request->input('page_width');
            $template->page_height = $request->input('page_height');


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
