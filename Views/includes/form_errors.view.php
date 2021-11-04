<?php if ($this->hasErrors()) : ?>

    <div class="flex flex-col gap-1 mb-2">
        <?php foreach ($this->errors['errors'] as $key => $error) : ?>
            <div class="text-red-500 text-sm"> <?php echo $error ?> </div>
        <?php endforeach ?>
    </div>

<?php endif ?>
