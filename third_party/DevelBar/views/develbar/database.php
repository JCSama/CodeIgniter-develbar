<img src="<?php echo $icon ?>" title="<?php echo lang('database') ?>"
     alt="<?php echo lang('database') ?>"/> <?php echo(count($dbs) ? lang('database') : 'N/A') ?>
<?php if(count($dbs)): ?>
<div class="detail database">
    <?php foreach ($dbs as $name => $db):
        if (count($db->queries)){
            $total_execution_time = 0;
            echo '<div class="scroll">';
            foreach ($db->queries as $key => $query) {
                $time = number_format($db->query_times[$key], 4);
                $total_execution_time = number_format(array_sum($db->query_times), 4);

                $highlight = array('SELECT', 'DISTINCT', 'FROM', 'WHERE', 'AND', 'LEFT&nbsp;JOIN', 'ORDER&nbsp;BY', 'GROUP&nbsp;BY', 'LIMIT', 'INSERT', 'INTO', 'VALUES', 'UPDATE', 'OR&nbsp;', 'HAVING', 'OFFSET', 'NOT&nbsp;IN', 'IN', 'LIKE', 'NOT&nbsp;LIKE', 'COUNT', 'MAX', 'MIN', 'ON', 'AS', 'AVG', 'SUM', '(', ')');
                //$query = highlight_code($query);
                foreach ($highlight as $bold) {
                    $query = str_replace($bold, '<strong style="color:#e0e0e0">'.$bold.'</strong>', $query);
                }
                echo '
                <p>
                    <span class="left-col">' . $query . '</span>
                    <span class="right-col">' . $time . ' ' .lang('sec') .'</span>
                </p>';
            }

            echo '
            </div>
            <p style="border-top:1px solid #57595E;">
                <span class="left-col">' . lang('total_execution_time') . '</span>
                <span class="right-col">' . $total_execution_time . ' ' .lang('sec') .'</span>
            </p>';
        }
        else{
            echo lang('no_queries');
        }
        ?>
    <?php endforeach ?>
</div>
<?php endif; ?>
