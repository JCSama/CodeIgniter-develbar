<img src="<?php echo $icon ?>"
     alt="<?php echo lang('config') ?>" title="<?php echo lang('config') ?>"/> <?php echo lang('config') ?>
<?php if (count($loaded_hooks)): ?>
    <div class="detail config">
        <div class="scroll">
            <?php
            foreach ($configuration as $config => $val) {
                if (is_array($val) OR is_object($val)) {
                    $val = print_r($val, true);
                }
                echo '<p>';
                echo '<span class="left-col" style="width:40%"><strong>' . $config . ':</strong></span>';
                echo '<span class="right-col" style="width:60%"><pre>' . htmlentities($val) . '</pre></span>';
                echo '</p>';
            }
            ?>
        </div>
    </div>
<?php endif; ?>
