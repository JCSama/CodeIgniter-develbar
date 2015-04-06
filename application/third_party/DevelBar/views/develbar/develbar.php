<!-- START CodeIgniter Developer Toolbar -->
<style type="text/css">
    <?php echo $css ?>
</style>
<div class="develbar">
    <ul class="develbar-nav">
        <li class="none"><img src="<?php echo $logo ?>" alt="codeIgniter" />
            <div class="detail">
                <p>CodeIgniter version : <?php echo $ci_version ?></p>
                <?php if($ci_new_version !== FALSE): ?>
                    <p>
                    <span class="label warning">Info</span>Update is available to <?php echo anchor(config_item('ci_download_link'), $ci_new_version, 'target="_blank"') ?>
                    </p>
                <?php endif ?>
                <p><?php echo anchor(config_item('documentation_link'), 'CodeIgniter documentation', 'target="_blank"') ?></p>
                <p>DevelBar version : <?php echo $develBar_version ?></p>
                <p>PHP version : <?php echo PHP_VERSION ?></p>

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
