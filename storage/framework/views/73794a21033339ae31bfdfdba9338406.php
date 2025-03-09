

<?php $__env->startSection('title', 'Crear Template'); ?>

<?php $__env->startSection('content_header'); ?>
<h1></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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

            <?php if($errors->any()): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="row">
                <h2 class="text-center mb-4">Formulario de Creacion de Templates</h2>
            </div>

            <form enctype="multipart/form-data" action="<?php echo e(route('admin.templates.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="template_image_path">Imagen del Template:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>

                <div class="form-group">
                    <label for="qr_x">Posición QR (X):</label>
                    <input type="number" step="0.01" class="form-control" id="qr_x" name="qr_x" required>
                </div>

                <div class="form-group">
                    <label for="qr_y">Posición QR (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="qr_y" name="qr_y" required>
                </div>

                <div class="form-group">
                    <label for="alumn_name_x">Posición Nombre Alumno (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_name_x" name="alumn_name_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_name_y">Posición Nombre Alumno (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_name_y" name="alumn_name_y" required>
                </div>

                <div class="form-group">
                    <label for="alumn_finishCourseDate_x">Posición Fecha de Finalización del Curso (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_x" name="alumn_finishCourseDate_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_finishCourseDate_y">Posición Fecha de Finalización del Curso (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_finishCourseDate_y" name="alumn_finishCourseDate_y" required>
                </div>

                <div class="form-group">
                    <label for="alumn_courseName_x">Posición Nombre del Curso (X):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_courseName_x" name="alumn_courseName_x" required>
                </div>

                <div class="form-group">
                    <label for="alumn_courseName_y">Posición Nombre del Curso (Y):</label>
                    <input type="number" step="0.01" class="form-control" id="alumn_courseName_y" name="alumn_courseName_y" required>
                </div>

                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="<?php echo e(route('admin.templates.index')); ?>">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar Template</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/admin/templates/create.blade.php ENDPATH**/ ?>