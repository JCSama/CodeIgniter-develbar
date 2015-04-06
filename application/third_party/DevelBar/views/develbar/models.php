<img src="<?php echo $icon ?>"
     alt="Models"/> <?php echo lang('models') . ' (' . count($models) . ')' ?>
<?php if(count($models)): ?>
<div class="detail models">
    <div class="scroll">
    <?php
    foreach ($models as $model) {
        echo '
            <p>
                <span class="left-col"><strong>' . $model . '</strong></span>';
        echo '</p>';
    }
    ?>
    </div>
</div>
<?php endif; ?>
