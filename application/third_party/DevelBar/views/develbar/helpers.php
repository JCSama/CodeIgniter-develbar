<img src="<?php echo $icon ?>"
     alt="Helpers"/> <?php echo lang('helpers') . ' (' . count($helpers) . ')' ?>
<?php if(count($helpers)): ?>
<div class="detail">
    <div class="scroll">
    <?php
    foreach (array_keys($helpers) as $helper) {
        echo '
            <p>
                <span class="left-col"><strong>' . ucfirst($helper) . '</strong></span>';
        echo '</p>';
    }
    ?>
    </div>
</div>
<?php endif; ?>
