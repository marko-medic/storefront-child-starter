<?php


function sfc_dd($arg, $print = false)
{
    ?> 
    <pre style="border: 5px solid pink; color: gold; background-color: black; padding: 1rem;">
        <?php
        if ($print) {
            print_r($arg);
        } else {
            var_dump($arg);
        }
  
        die;
        ?>
         
            
    </pre>
    <?php
}