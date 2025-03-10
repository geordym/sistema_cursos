<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Illuminate\Http\Request;

use Intervention\Image\Laravel\Facades\Image;
use FPDF;


use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Date;

class ImageController extends Controller
{
    //

    public function generateCertifyPDF2()
    {
        $certificadoImagePath = 'C:\laragon\www\ep_sistema3\storage\EP sistema\certificado_template.png';
        $image = Image::read($certificadoImagePath);

        // Agregar texto
        $image->text('GEORDY MONTENEGRO MOSQUERA', 1500, 1210, function ($font) {
            $font->file('C:\Windows\Fonts\times.ttf');
            $font->size(100);
            $font->color('#1C1B17'); // Color del texto
            $font->align('center');
            $font->valign('top');
        });

        // Guardar en el directorio temporal de Windows
        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'nueva_imagen.png';
        $image->save($tmpPath);

        // Retornar la imagen como respuesta HTTP y eliminar el archivo temporal después de enviarlo
        return response()->file($tmpPath)->deleteFileAfterSend(true);
    }


    public function generateCertifyPDF($template, $code, $textUnderCode, $alumnName, $finishCourseDate, $courseName)
    {

        $absolutePath = storage_path('app/' . $template->template_image_path);
        $image = Image::read($absolutePath);


        $QR_SIZE = $template->qr_size ?? 150;
        $qrPathImage = $this->generateQRCode($code, $textUnderCode, $QR_SIZE);

        $qrImage = Image::read($qrPathImage);

        $qrX = $template->qr_x;
        $qrY = $template->qr_y;

        $alumnX = $template->alumn_name_x;
        $alumnY = $template->alumn_name_y;

        $finishCourseDateX = $template->alumn_finishCourseDate_x;
        $finishCourseDateY = $template->alumn_finishCourseDate_y;

        $courseNameX = $template->alumn_courseName_x;
        $courseNameY = $template->alumn_courseName_y;


        $image->place($qrImage, 'top-left', $qrX, $qrY);


        $image->text($alumnName, $alumnX, $alumnY, function ($font) use ($template) {
            $ALUMN_NAME_TEXT_SIZE = $template->alumn_name_text_size ?? 35;
            $ALUMN_NAME_TEXT_COLOR = $template->alumn_name_text_color ?? '#1C1B17';
            $ALUMN_NAME_TEXT_ALIGN = $template->alumn_name_text_align ?? 'center';


            $font->file(storage_path('EP sistema/times.ttf'));
            $font->size($ALUMN_NAME_TEXT_SIZE);
            $font->color($ALUMN_NAME_TEXT_COLOR);
            $font->align($ALUMN_NAME_TEXT_ALIGN);
            $font->valign('top');
        });





        $image->text($finishCourseDate, $finishCourseDateX, $finishCourseDateY, function ($font) use ($template){
            $FINISH_COURSE_TEXT_SIZE = $template->finish_course_text_size ?? 35;
            $FINISH_COURSE_TEXT_COLOR = $template->finish_course_text_color ?? '#1C1B17';
            $FINISH_COURSE_TEXT_ALIGN = $template->finish_course_text_align ?? 'center';


            $font->file(storage_path('EP sistema/times.ttf'));
            $font->size($FINISH_COURSE_TEXT_SIZE);
            $font->color($FINISH_COURSE_TEXT_COLOR);
            $font->align($FINISH_COURSE_TEXT_ALIGN);
            $font->valign('top');
        });


        $image->text($courseName, $courseNameX, $courseNameY, function ($font) use ($template){
            $COURSE_NAME_TEXT_SIZE = $template->course_name_text_size ?? 35;
            $COURSE_NAME_TEXT_COLOR = $template->course_name_text_color ?? '#1C1B17';
            $COURSE_NAME_TEXT_ALIGN = $template->course_name_text_align ?? 'center';

            $font->file(storage_path('EP sistema/times.ttf'));
            $font->size($COURSE_NAME_TEXT_SIZE);
            $font->color($COURSE_NAME_TEXT_COLOR);
            $font->align($COURSE_NAME_TEXT_ALIGN);
            $font->valign('top');
        });


        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('imagen_', true) . '.png';
        $image->save($tmpPath);

        return $tmpPath;
    }


    public function generateQRCode($codeText, $textUnderCode, $qrSize)
    {
        // Crear el objeto QrCode con el texto proporcionado
        $qrCode = new QrCode($codeText);

        // Ajustar el tamaño del QR (por ejemplo, 150 px en lugar de 300 px)
        $qrCode->setSize($qrSize); // Cambia el valor según lo que necesites para hacerlo más pequeño

        // Crear el escritor para guardar la imagen como PNG
        $writer = new PngWriter();

        $label = new Label(
            text: $textUnderCode,  // El texto que quieres agregar debajo del QR
            textColor: new Color(0, 0, 255)
        );

        // Definir la ruta temporal donde se guardará el archivo QR
        $tempDir = sys_get_temp_dir();
        $qrCodePath = $tempDir . DIRECTORY_SEPARATOR . 'qr_code_' . uniqid() . '.png';

        // Generar y guardar el código QR como un archivo
        $result = $writer->write($qrCode, null, $label);
        $result->saveToFile($qrCodePath);

        // Retornar la ruta del archivo generado
        return $qrCodePath;
    }



    public function viewExampleCertify($courseId)
    {
        $course = Course::find($courseId);

        $certifyCode = $this->generateCertifyCode(
            $course->name,
            $course->hour_load,
            1,
            1,
            1,
            "2024-11-23"
        );

        $imagePath = $this->generateCertifyPDF(
            $course->course_template,
            $certifyCode,
            $certifyCode,
            "LUISA VALERIA GONZALEZ JIMENEZ",
            "2024-11-23",
            "Curso en manipulacion y operacion de imagenes"
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

    function imageToPdf($imagePath, $pdfPath, $template)
    {

        $orientation = $template->orientation ?? "L";
        // Crear una instancia de FPDF con orientación horizontal ('L')
        $pdf = new FPDF($orientation, 'mm', 'A4');
        $pdf->AddPage();

        // Dimensiones de la página A4 en orientación horizontal (A4 landscape)
        $pageWidth = 297; // Ancho de A4 en landscape
        $pageHeight = 210; // Alto de A4 en landscape

        // Insertar la imagen en el PDF para que ocupe toda la página
        $pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight);

        // Guardar el PDF en la ruta especificada
        $pdf->Output('F', $pdfPath);
    }
}
