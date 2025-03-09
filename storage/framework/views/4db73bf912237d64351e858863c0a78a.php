

<?php $__env->startSection('title', 'Expedir certificados'); ?>

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
                <h2 class="text-center mb-4">Expedir certificados</h2>
            </div>

            <form action="<?php echo e(route('collaborators.certification.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="course">Curso:</label>
                    <select class="form-control" id="course" name="course" required>
                        <option value="" disabled selected>Seleccione un curso</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($course->id); ?>"><?php echo e($course->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <label>Selecciona los alumnos</label>



                <select multiple="multiple" id="select_alumns" name="alumnos[]">
                    <?php $__currentLoopData = $alumns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alumno): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($alumno->id); ?>"><?php echo e($alumno->fullname); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <button class="btn btn-primary">EXPEDIR</button>
            </form>
        </div>
    </div>
</div>

<script>
    let select = document.querySelector("#select_alumns");
    let dualListbox = new DualListbox(select, {
        availableTitle: "Lista de alumnos",
        selectedTitle: "Alumnos a certificar",
    });
    dualListbox.add_button.classList.add("btn", "bg-primary"); // Botón de agregar
    dualListbox.add_all_button.classList.add("btn", "bg-success"); // Botón de agregar todos
    dualListbox.remove_button.classList.add("btn", "bg-info"); // Botón de quitar
    dualListbox.remove_all_button.classList.add("btn", "bg-danger"); // Botón de quitar todos


    dualListbox.add_button.textContent = "Agregar";
    dualListbox.add_all_button.textContent = "Agregar todos";
    dualListbox.remove_button.textContent = "Quitar";
    dualListbox.remove_all_button.textContent = "Quitar todos";

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ep_sistema3\resources\views/collaborators/certifications/create.blade.php ENDPATH**/ ?>