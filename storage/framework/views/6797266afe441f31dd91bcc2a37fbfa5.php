

<?php $__env->startSection('title', 'Expedir certificados'); ?>

<?php $__env->startSection('content_header'); ?>
<h1></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de certificados</h2>
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Codigo</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Fecha de Creación</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($certify->certify_code); ?></td>
                    <td><?php echo e($certify->student_fullname); ?></td>
                    <td><?php echo e($certify->student_curp); ?></td>
                    <td><?php echo e($certify->created_at->format('d/m/Y H:i')); ?></td>
                    <td>
                        <a class="btn btn-danger" href="<?php echo e($certify->getUrlPathAttribute()); ?>">Descargar Certificado</a>
                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/collaborators/certifications/show.blade.php ENDPATH**/ ?>