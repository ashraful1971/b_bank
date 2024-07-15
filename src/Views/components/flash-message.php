<?php if ($msg = flash_message('success')) : ?>
    <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
        <span class="font-medium">Success!</span> <?php __($msg) ?>
    </div>
<?php endif ?>
<?php if ($msg = flash_message('error')) : ?>
    <div class="p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
        <span class="font-medium">Error!</span> <?php __($msg) ?>
    </div>
<?php endif ?>