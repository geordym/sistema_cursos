

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
        <h1>Templates</h1>

    </div>
    <div class="row">

        <div class="row">
            <a type="button" href="<?php echo e(route('admin.templates.create')); ?>" class="ml-2 btn btn-primary">
                Crear Template
            </a>
            <a type="button" href="<?php echo e(route('admin.templates.course.assign')); ?>" class="ml-2 btn btn-info">
                Asignar Template a Curso
            </a>
        </div>
       

    </div>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Lista de Templates</h2>
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Path de Imagen</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($template->id); ?></td>
                    <td><?php echo e($template->name); ?></td>
                    <td><?php echo e($template->template_image_path); ?></td>
                    <td>
                        <a href="<?php echo e(route('admin.templates.edit', $template->id)); ?>" class="btn btn-primary">Editar</a>

                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        

    </div>


    
    <div class="container mt-4">
        <h2 class="text-center mb-4">Cursos con templates asignados</h2>
        <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Curso ID</th>
                    <th scope="col">Curso Nombre</th>
                    <th scope="col">Curso Impartido Por</th>
                    <th scope="col">Template ID</th>
                    <th scope="col">Template Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($course->id); ?></td>
                    <td><?php echo e($course->name); ?></td>
                    <td><?php echo e($course->collaborator->name); ?></td>
                    <td><?php echo e($course->template->id); ?></td>
                    <td><?php echo e($course->template->name); ?></td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </div>

    <br>
    <br>
    <br>
    <br>
    <br>

</div>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/admin/templates/index.blade.php ENDPATH**/ ?>