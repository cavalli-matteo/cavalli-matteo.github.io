<?php
    $rscard_options = get_option('rscard_options');
?>
    <ul class="social">
        <?php if($rscard_options['social-1'] && $rscard_options['social-1-link']):?>
            <li><a href="<?php echo esc_url($rscard_options['social-1-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-1']);?>"></i></a></li>
        <?php
            endif;
            if($rscard_options['social-2'] && $rscard_options['social-2-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-2-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-2']);?>"></i></a></li>
        <?php
            endif;
            if($rscard_options['social-3'] && $rscard_options['social-3-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-3-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-3']);?>"></i></a></li>
        <?php
            endif;
            if($rscard_options['social-4'] && $rscard_options['social-4-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-4-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-4']);?>"></i></a></li>
        <?php
            endif;
            if($rscard_options['social-5'] && $rscard_options['social-5-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-5-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-5']);?>"></i></a></li>
        <?php
            endif;
            if($rscard_options['social-6'] && $rscard_options['social-6-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-6-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-6']);?>"></i></a></li>
        <?php 
			endif;     
			if($rscard_options['social-7'] && $rscard_options['social-7-link']):
        ?>
        <li><a href="<?php echo esc_url($rscard_options['social-7-link']);?>" target="_blank"><i class="rsicon rsicon-<?php echo esc_attr($rscard_options['social-7']);?>"></i></a></li>
        <?php endif;?>
    </ul>