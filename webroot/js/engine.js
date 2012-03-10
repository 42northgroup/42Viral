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
 ** @author Jason D Snider <jason.snider@42viral.org>
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

/**
 * Start up functionality
 */
$(function(){
    
    /**
     * A function for removing array elements by value
     * param array [array] the array to be spliced
     * param string [value] - The target value
     * return void
     */
    function spliceByValue(array ,value) {
        for(var i = array.length-1; i >= 0; i--) {
            if(array[i] == value) {
                array.splice(i,1);
            }
        }
    }
    
    /**
     * Left hand navigation
     */
    //collects the ids of elements to have opened
    var values = new Array();
    
    //Lights up the drop down indicator
    $('#MainLeft').delegate('h4', 'mouseenter', function() {
        if(!$(this).next().is(':visible')) {
            $(this).find('span.side-navigation-toggle:first').attr('style', 'color:#555'); 
        }
    });
    
    //Dims up the drop down indicator
    $('#MainLeft').delegate('h4', 'mouseleave', function() {
        if(!$(this).next().is(':visible')) {
            $(this).find('span.side-navigation-toggle:first').attr('style', 'color:#e2e2e2'); 
        }  
    });
    
    //Toggles a menus state
    $('#MainLeft').delegate('h4', 'click', function() {
        var name = $(this).attr('id');
        $(this).next().toggle();   
        
        if($(this).next().is(':visible')) {
            $(this).find('span.side-navigation-toggle:first').attr('style', 'color:#555');
            values.push(name);
        } else {
            $(this).find('span.side-navigation-toggle:first').attr('style', 'color:#e2e2e2');
            spliceByValue(values, name);
        }
        
        localStorage.setItem('OpenNavigationBlocks', values);

    });
    
    var openNavigationBlocks = [];
    
    if(localStorage.getItem('OpenNavigationBlocks') !== null) {
        //Parse the localStorage data to determine what menus to open
        openNavigationBlocks = localStorage.getItem('OpenNavigationBlocks').split(',');
    }
    
    //Get rid of any empty elements
    spliceByValue(openNavigationBlocks, '');
    
    for (i=0;i<openNavigationBlocks.length;i++)
    {
        //Open the navigation block (menu)
        $('#' + openNavigationBlocks[i]).next().show();   
        $('#' + openNavigationBlocks[i]).find("span.side-navigation-toggle:first").attr('style', 'color:#555');
        //Rebuild the localStorage array
        values.push(openNavigationBlocks[i]);
    }  
    
    //Rebuild the localStorage array
    localStorage.setItem('OpenNavigationBlocks', values);    
    
    //HeaderRight navigation
    $('#HeaderRight').delegate('.navigation-link', 'mouseover', function(){
        $('.navigation-block').hide();
        var id = $(this).attr('id');
        $('#' + id + 'Block').show();
    });           
   
     $('#HeaderRight').mouseleave(function(){
        $('.navigation-block').hide();
    }); 
    
    //Section manager navigation
    $('#SectionManager').delegate('.section-navigation-link', 'mouseover', function(){
        $('.section-navigation-block').hide();
        var id = $(this).attr('id');
        $('#' + id + 'Block').show();
    });   

    $('#SectionManager').mouseleave(function(){
        $('.section-navigation-block').hide();
    });  
    
    //Profile manager navigation
    $('#ProfileManager').delegate('.profile-navigation-link', 'mouseover', function(){
        $('.profile-navigation-block').hide();
        var id = $(this).attr('id');
        $('#' + id + 'Block').show();
    });   
    
    $('#ProfileManager').mouseleave(function(){
        $('.profile-navigation-block').hide();
    });     

    //Local manager navigation
    $('#LocalManager').delegate('.local-navigation-link', 'mouseover', function(){
        $('.local-navigation-block').hide();
        id = $(this).attr('id');
        $('#' + id + 'Block').show();
    });           

    $('#LocalManager').delegate('.local-navigation-block', 'mouseleave', function(){
        $('.local-navigation-block').hide();
    });  
    
    $('.delete-confirm').click(function() {
        return confirm('Are you sure you want to delete this record?');
    });
    
    /* Controls table navigation in regaurds to double row stacking */
    $(function(){
        $('tr').delegate('.actions-control','mouseenter',function(){
            $(this).find('div.actions:first').toggle();
        });
    });

    $(function(){
        $('tr').delegate('.actions-control','mouseleave',function(){
            $(this).find('div.actions:first').toggle();
        });
    });    
});
