<img src="<?php echo $icon ?>" title="<?php echo lang('views') ?>"
     alt="<?php echo lang('views') ?>"/> <?php echo lang('views') . ' (' . count($views) . ')' ?>
<?php if(count($views)): ?>
<div class="detail views">
    <div class="scroll">
    <?php
    foreach ($views as $path => $view) {
        $path = explode('/', $path);
        $path[count($path)-1] = '<span style="color:#FFF">'.end($path).'</span>';
        echo '
            <p>
                <span class="left-col"><strong>' . implode('<span style="color:#FFF">/</span>', $path) . '</strong></span>';
        echo '</p>';
    }
    ?>
    </div>
</div>
<?php endif; ?>
