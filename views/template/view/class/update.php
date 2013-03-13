<?php echo $file_security ?>


<?php if ( ! $standalone): ?>
class View_<?php echo $class_name ?> extends View_<?php echo str_replace('_Update', '_Create', $class_name) ?> {}
<?php else: ?>
class View_<?php echo $class_name ?> {

}
<?php endif ?>