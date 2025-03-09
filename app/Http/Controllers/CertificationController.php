<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseCertificate;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumn;
use App\Models\Collaborator;
use App\Models\Course;
use App\Models\TokenLog;
use Carbon\Carbon;
use FPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CertificationController extends Controller
{

    private $imageController;
    private $CREDITS_PER_CERTIFICATE = 1;

    public function __construct()
    {
        $this->imageController = new ImageController();
    }

    public function showSearchForm(){
        return view('welcome');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuthenticatedId = Auth::id();

        $certifications = CourseCertificate::orderBy('created_at', 'DESC')->where('collaborator_id', $userAuthenticatedId)->get();
        return view('collaborators.certifications.index')->with('certifications', $certifications);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userAuthenticatedId = Auth::id();

        $courses = Course::orderBy('created_at', 'DESC')->where('collaborator_id', $userAuthenticatedId)->get();
        $alumns = Alumn::where('collaborator_id', $userAuthenticatedId)->get();
        return view('collaborators.certifications.create')->with('alumns', $alumns)->with('courses', $courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $courseId = $request->input('course');
        $alumns = $request->input('alumnos');
        $fechaActual = Carbon::now();

        $validator = Validator::make($request->all(), [
            'alumnos' => 'required|array|min:1',  // El campo 'alumnos' debe ser un array con al menos un elemento
            'course' => 'required|exists:courses,id',  // El ID del curso debe ser obligatorio y debe existir en la tabla 'courses'
        ]);

        // Si la validación falla, se redirige de vuelta con los errores
        if ($validator->fails()) {
            // Redirige con los errores y los datos de entrada previos
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!$this->haveEnoughTokens(count($alumns))) {
            // Redirigir al usuario de vuelta con un mensaje de error
            return redirect()->route('collaborators.certification.create')
                ->with('error', 'No tienes suficientes tokens para generar las certificaciones.');
        }

        $course = Course::find($courseId);

        $certifications = [];
        try {
            foreach ($alumns as $alumnId) {
                $alumn = Alumn::find($alumnId);
                $collaboratorId = $course->collaborator_id;
                $collaborator = Collaborator::find($collaboratorId);

                // Crear el CourseCertificate
                $courseCertificate = CourseCertificate::create([
                    'certify_code' => "PENDING",
                    'student_fullname' => $alumn->fullname,
                    'student_curp' => $alumn->curp,
                    'course_name' => $course->name,
                    'course_hour_load' => $course->hour_load,
                    'issue_date' => $fechaActual,
                    'instructor_name' => $collaborator->name,
                    'collaborator_id' => $collaborator->id
                ]);

                // Generar el código de certificación
                $certifyCode = $this->generateCertifyCode(
                    $course->name,
                    $course->hour_load,
                    $collaboratorId,
                    $alumnId,
                    $courseCertificate->id,
                    $fechaActual
                );

                // Actualizar el código de certificación
                $courseCertificate->certify_code = $certifyCode;
                $courseCertificate->update();


                // Generar el PDF de la certificación
                $imagePath = $this->imageController->generateCertifyPDF(
                    $course->template,
                    $courseCertificate->certify_code,
                    $courseCertificate->student_fullname,
                    $courseCertificate->issue_date->format('d/m/Y'),
                    $courseCertificate->course_name
                );

                dd("Unable to decode ");
                // Convertir la imagen a PDF y guardar en almacenamiento
                $certifyPdfTempPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('imagen_', true) . '.pdf';
                $this->imageToPdf($imagePath, $certifyPdfTempPath);
                $pdfContent = file_get_contents($certifyPdfTempPath);
                $storagePath = 'images/' . basename($certifyPdfTempPath);
                Storage::disk('public')->put($storagePath, $pdfContent);

                // Actualizar la ruta del archivo de la certificación
                $courseCertificate->certify_path = $storagePath;
                $courseCertificate->update();

                // Almacenar la certificación en el array
                $certifications[] = $courseCertificate;

                // Actualizar los tokens del colaborador
                $collaborator->tokens = $collaborator->tokens - $this->CREDITS_PER_CERTIFICATE;
                $collaborator->save(); // Guardar el cambio en los tokens


                $studentFullname = $alumn->fullname;
                $certifyCode = $courseCertificate->certify_code;
                $fechaActualFormatted = $fechaActual->format('d/m/Y');

                // Crear la descripción del registro de token
                $tokenLogDescription = "Creación de certificado el {$fechaActualFormatted}, con código {$certifyCode} para el alumno {$studentFullname} con costo de {$this->CREDITS_PER_CERTIFICATE} token";

                
                TokenLog::create([
                    'user_id' => $collaborator->id,  // Usamos el ID del colaborador como 'user_id'
                    'description' => $tokenLogDescription, // Descripción del log
                    'tokens' => $this->CREDITS_PER_CERTIFICATE, // Los créditos o tokens que se deducen
                    'type' => 'deduction'  // El tipo de transacción
                ]);
                
            }

            // Confirmar los cambios en la base de datos
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return view('collaborators.certifications.show')->with('certifications', $certifications);
    }

    public function haveEnoughTokens(int $quantityCertifications): bool
    {
        // Definir los créditos por certificado

        // Obtener los tokens actuales del colaborador
        $currentTokens = Auth::user()->collaborator ? Auth::user()->collaborator->tokens : 0;

        // Calcular el costo de la operación
        $operationCost = $this->CREDITS_PER_CERTIFICATE * $quantityCertifications;

        // Verificar si el usuario tiene suficientes tokens
        if ($operationCost > $currentTokens) {
            return false;
        }

        return true;
    }


    function imageToPdf($imagePath, $pdfPath)
    {
        // Crear una instancia de FPDF con orientación horizontal ('L')
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Dimensiones de la página A4 en orientación horizontal (A4 landscape)
        $pageWidth = 297; // Ancho de A4 en landscape
        $pageHeight = 210; // Alto de A4 en landscape

        // Insertar la imagen en el PDF para que ocupe toda la página
        $pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight);

        // Guardar el PDF en la ruta especificada
        $pdf->Output('F', $pdfPath);
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function search(Request $request)
    {
        $request->validate([
            'certificate_code' => 'required|string',
        ]);

        $certificateCode = $request->input('certificate_code');

        // Busca el certificado en la base de datos
        $certificate = CourseCertificate::where('certify_code', $certificateCode)->first();

        if ($certificate) {
            return view('certificate_result', compact('certificate'));
        } else {
            return view('certificate_result', compact('certificate'));
        }
    }

}
