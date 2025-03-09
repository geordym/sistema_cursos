

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
        <h1>Cursos</h1>

    </div>
    <div class="row">

    </div>
    <div class="container mt-4">
    <h2 class="text-center mb-4">Lista de Cursos</h2>
    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Duracion en horas</th>
                <th scope="col">Fecha de Creación</th>
                <th scope="col">Acciones</th>

            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($course->id); ?></td>
                <td><?php echo e($course->name); ?></td>
                <td><?php echo e($course->hour_load); ?></td>
                <td><?php echo e($course->created_at->format('d/m/Y H:i')); ?></td> 
                <td>
                    <a class="btn btn-primary" href="<?php echo e(route('admin.courses.edit_template', $course->id)); ?>">Editar Template Curso</a>
                </td> 
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/admin/courses/index.blade.php ENDPATH**/ ?>