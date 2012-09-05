<?php
/**
 * The intent is to display a responsive sidebar by passing an array of elements to be displayed. These elements are
 * then pulled into the responsive wrapper.
 *
 * Passing an element a string will simply make a call to that element, passing the element as an array in the
 * format of $key=>$options, with the $key being the path to the element and $options being the standard
 * arguments expected by the View::element() method, it will make an element call in the format of
 * View::element(string, array)
 *
 * echo $this->element(
 *      'Blocks' . DS . 'aside',
 *      array(
 *          'elements'=>array(
 *              ## Pass elements with no arguments
 *              'Blocks' . DS . 'tag_cloud',
 *              ## AND/OR Pass elements with arguments
 *              array('Navigation' . DS . 'menus', array('section'=>'social_network'))
 *          )
 *      )
 *  );
 */
?>
<div id="Aside" class="clearfix mobile block">
    <div class="btn btn-navbar" style="float:left;">
    </div>
    <div id="AsideNavigationTrigger" class="btn btn-navbar" style="float:right;">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </div>
</div>

<div id="AsideNavigation" class="desktop block">

    <?php
    foreach($elements as $element):

        if(is_array($element)):
            //Get the element with args
            $path = $element[0];
            $options = $element[1];
        else:
            //Get the element without args
            $path = $element;
            $options = array();
        endif;

        echo $this->element($path, $options);

    endforeach;
    ?>
</div>