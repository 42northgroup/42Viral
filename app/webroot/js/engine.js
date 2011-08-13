/**
 * engine.js
 *
 * Copyright 2011, MicroTrain Technologies
 * Licensed under The MIT License
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
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