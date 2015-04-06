<!-- START CodeIgniter Developer Toolbar -->
<style type="text/css">
    <?php echo $css ?>
</style>
<div class="develbar">
    <ul class="develbar-nav">
        <li class="none"><img src="<?php echo $logo ?>" alt="CodeIgniter" />
            <div class="detail">
                <p><?php echo sprintf(lang('ci_version'), $ci_version) ?></p>
                <?php if($ci_new_version !== FALSE): ?>
                    <p>
                    <span class="label warning"><?php echo lang('info') ?></span>
                        <?php echo sprintf(lang('update_message'), anchor($config['ci_download_link'], $ci_new_version, 'target="_blank"')) ?>
                    </p>
                <?php endif ?>
                <p><?php echo anchor($config['documentation_link'], 'CodeIgniter documentation', 'target="_blank"') ?></p>
                <p><?php echo sprintf(lang('develbar_version'), $develBar_version) ?></p>
                <p><?php echo sprintf(lang('php_version'), PHP_VERSION) ?></p>
            </div>
        </li>
        <?php if(count($views)): ?>
            <?php foreach($views as $view): ?>
                <li><?php echo $view ?></li>
            <?php endforeach ?>
        <?php endif ?>
    </ul>
</div>
<!-- END CodeIgniter Developer Toolbar -->
