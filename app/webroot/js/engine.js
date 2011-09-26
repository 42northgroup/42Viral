/**
 * JavaScript
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 **** @author Jason D Snider <jason.snider@42viral.org>
 * 
 * //Additional Credits
 * @see JavaScript The Good Parts - Douglas Crawford
 * @see http://blog.nategood.com/finally-grasping-prototypical-object-oriented
 */

/**
 * Encapsulates prototyping
 * 
 * Usage examples
 * // Define a Person as an Object Literal
 * var Person = {
 *     name: null,
 *     sayMyName: function() {
 *         alert(this.name);
 *     }
 * };
 *
 * var nathan = extend(Person);
 * nathan.name = "Nathan";
 * 
 * var jason = extend(Person);
 * jason.name = "Jason";   
 * 
 * var bob = extend(Person);
 * bob.name = "Bob";   
 *  
 * nathan.sayMyName();
 * bob.sayMyName();   
 * jason.sayMyName();   
 * bob.sayMyName(); 
 * 
 * @see JavaScript The Good Parts Douglas Crawford
 * @link http://blog.nategood.com/finally-grasping-prototypical-object-oriented
 */
function extend(object) {
    function F() {}
    F.prototype = object;
    return new F();
}    


/**
 * Default application wide AJAX settings 
 */
$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

$(function(){
    
    //HeaderRight navigation
    $('#HeaderRight').delegate('.navigation-link', 'mouseover', function(){
        $('.navigation-block').hide();
        id = $(this).attr('id');
        $('#' + id + 'Block').slideDown();
    });           

    $('#HeaderRight').delegate('.navigation-block', 'mouseleave', function(){
        $('.navigation-block').slideUp();
    });  
    
});
