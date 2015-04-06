<img src="<?php echo $icon ?>" alt="Request" /> <?php echo lang('request') . ' : ' . $controller . '/'. $action ?>
<div class="detail request">
    <p>
        <span class="left-col"><?php echo lang('method') ?> :</span>
        <span class="right-col"><?php echo strtoupper($method) ?></span>
    </p>

    <?php if(count($parameters)): ?>
        <p>
            <span class="left-col"><?php echo lang('parameters') ?> :</span>
        </p>
        <p>
            <span class="right-col" style="float:none"><pre style="color:#FFF"><?php print_r($parameters) ?></pre></span>
        </p>
    <?php endif ?>
</div>
