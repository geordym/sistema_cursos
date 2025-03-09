

<?php $__env->startSection('title', 'Crear colaboradors'); ?>

<?php $__env->startSection('content_header'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="container">

    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>


    <div class="row">
        <h1>Certificados</h1>

    </div>
    <div class="row">
        <a type="button" href="<?php echo e(route('collaborators.certification.create')); ?>" class="btn btn-primary">
            Certificar
        </a>
    </div>

    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Certificaciones expedidas</h2>

        <!-- Mensajes de éxito o error -->
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php endif; ?>

        <!-- Tabla de certificaciones -->
        <table class="table table-striped table-hover table-bordered text-center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Código</th>
                    <th scope="col">Nombre del Alumno</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Fecha de Expedición <i class="fas fa-calendar-alt"></i></th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($certification->certify_code); ?></td>
                    <td><?php echo e($certification->student_fullname); ?></td>
                    <td><?php echo e($certification->course_name); ?></td>
                    <td><?php echo e($certification->issue_date); ?></td>
                    <td>
                        <a class="btn btn-danger" href="<?php echo e($certification->getUrlPathAttribute()); ?>">Descargar Certificado</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-muted">No hay certificaciones disponibles</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/collaborators/certifications/index.blade.php ENDPATH**/ ?>