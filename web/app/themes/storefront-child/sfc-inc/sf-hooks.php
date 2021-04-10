<?php
add_action(
    'storefront_before_header',
    function () {
        ?>
        <div id="root" class="sfc-content">
        <?php
    }
);


add_action(
    'storefront_after_footer',
    function () {
        ?>
    </div> <!-- /.sfc-content -->
        <?php
    }
);
