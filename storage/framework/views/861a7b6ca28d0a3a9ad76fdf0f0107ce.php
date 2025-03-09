

<?php $__env->startSection('title', 'Crear Curso'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Contenedor de ancho medio -->
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
                <h2 class="text-center mb-4">Formulario de Edicion de Template de Curso</h2>
            </div>

            <form enctype="multipart/form-data" action="<?php echo e(route('admin.courses.storeCertifyTemplate')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <input name="course_id" value="<?php echo e($course->id); ?>" type="hidden">
                <div class="form-group">
                    <label for="name">Imagen del certificado:</label>
                    <input type="file" class="form-control" id="image" name="image" required>
                </div>


                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" href="<?php echo e(route('admin.courses')); ?>">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Plantilla</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/admin/courses/edit_template.blade.php ENDPATH**/ ?>