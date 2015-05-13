<style>
    ul li{
        list-style-type:none;
    }
    li >div{
        display: inline-block;
    }
</style>
<ul id='dir'>
    <?php
    $dir = isset($_GET['dir']) ? $_GET['dir'] : '';
    foreach ($data as $line => $type) {
        if ($line == '.') {
            continue;
        }
        if ($dir) {
            $link = preg_replace('/\/+/', '/', $dir . '/') . $line;
        } else {
            $link = $line;
        }
        if ($type == 'f') {
            $url = Controller::url('dir', 'download', array('f' => $link));
        } else {
            $url = Controller::url('dir', '', array('dir' => $link));
        }
        ?>
        <li>
            <div><span>□</span></i><a href='<?php echo $url ?>'><?php echo $line ?></a></div>
            <div class="actions">
                <span>下载</span>
            </div>
        </li>
        <?php
    }
    ?>
</ul>