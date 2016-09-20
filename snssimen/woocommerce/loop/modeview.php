<?php
$modeview = snssimen_get_option('woo_list_modeview', 'grid');

if (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'grid') {
    $modeview = 'grid';
}elseif (isset($_COOKIE['sns_woo_list_modeview']) && $_COOKIE['sns_woo_list_modeview']== 'list') {
    $modeview = 'list';
}
?>
<ul class="mode-view pull-left">
    <li class="grid">
    	<a class="grid<?php echo ($modeview=='grid')?' active':''; ?>" data-mode="grid" href="#" title="<?php echo esc_attr__('Grid', 'snssimen'); ?>">
    		<i class="fa fa-th"></i><span><?php echo esc_html__('Grid', 'snssimen'); ?></span>
    	</a>
    </li>
    <li class="list">
    	<a class="list<?php echo ($modeview=='list')?' active':''; ?>" data-mode="list" href="#" title="<?php echo esc_attr__('List', 'snssimen'); ?>">
            <i class="fa fa-th-list"></i><span><?php echo esc_html__('List', 'snssimen'); ?></span>
        </a>
    </li>
</ul>