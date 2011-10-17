<!-- Jason Snider August 08, 2010 -->


<p>I have been doing some basic I/O on top of CakePHP recently and I decided to
    utilize CakePHP's built in Security Component to help defend against
    <a href="http://en.wikipedia.org/wiki/Cross-site_request_forgery" target="_blank">
        CSRF attacks</a>. I have ran into a few conflicts involving DOM
        manipulation and hidden fields. The documentation for the Security
        component seem to be lacking, so I thought I would take a minute and
        share what I found and how I resolved it.
</p>

<p>It appears as though CakePHP's Security component doesn't like it when hidden
    fields are manipulated. In this case I'm using JQuery and PHPJS to hash the
    user entered password and populate a hidden field. Upon submitting the form
    I blank out the password field and only submit the hashed version of the
    password via the hidden field. (My theory being if the application isn't
    installed over SSL at least there will be no email and password combos
    going over the wire in plain text) Needless to say the form kept going
    into a black hole. I turned all of the fields to visible and the black hole
    went away. That's when it occurred to me, manipulating the hidden field is
    making CakePHP angry. The solution was simple, set the field to
    type=&gt;text and apply a hidden div to the before and after options of the
    form field to be hidden.
</p>



<pre>
<div class="line" id="LC1">&lt;script type="text/javascript"&gt;</div>
<div class="line" id="LC2">&nbsp;&nbsp;&nbsp;&nbsp;$(function(){</div>
<div class="line" id="LC3"><br></div>
<div class="line" id="LC4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").keyup(function(){</div>
<div class="line" id="LC5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserHash").attr('value', sha1($("#UserPassword").val()));</div>
<div class="line" id="LC6"><br></div>
<div class="line" id="LC7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC8"><br></div>
<div class="line" id="LC9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserSubmit").click(function(){</div>
<div class="line" id="LC10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").attr('value','');</div>
<div class="line" id="LC11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div class="line" id="LC13">&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC14">&lt;/script&gt;</div>
<div class="line" id="LC15"><br></div>
<div class="line" id="LC16">&lt;div class="panel left"&gt;</div>
<div class="line" id="LC17">&nbsp;&nbsp;&nbsp;&nbsp;&lt;h2 class="headings"&gt;Account Login&lt;/h2&gt;</div>
<div class="line" id="LC18">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;create('User',</div>
<div class="line" id="LC19">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(</div>
<div class="line" id="LC20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class'=&gt;'form-panel'</div>
<div class="line" id="LC21">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)); ?&gt;</div>
<div class="line" id="LC22">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;input&lt;script type="text/javascript"&gt;</div>
<div class="line" id="LC23">&nbsp;&nbsp;&nbsp;&nbsp;$(function(){</div>
<div class="line" id="LC24"><br></div>
<div class="line" id="LC25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").keyup(function(){</div>
<div class="line" id="LC26">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserHash").attr('value', sha1($("#UserPassword").val()));</div>
<div class="line" id="LC27"><br></div>
<div class="line" id="LC28">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC29"><br></div>
<div class="line" id="LC30">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserSubmit").click(function(){</div>
<div class="line" id="LC31">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").attr('value','');</div>
<div class="line" id="LC32">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC33">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div class="line" id="LC34">&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC35">&lt;/script&gt;</div>
<div class="line" id="LC36"><br></div>
</pre>

<pre>
<div class="line" id="LC1">&lt;script type="text/javascript"&gt;</div>
<div class="line" id="LC2">&nbsp;&nbsp;&nbsp;&nbsp;$(function(){</div>
<div class="line" id="LC3"><br></div>
<div class="line" id="LC4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").keyup(function(){</div>
<div class="line" id="LC5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserHash").attr('value', sha1($("#UserPassword").val()));</div>
<div class="line" id="LC6"><br></div>
<div class="line" id="LC7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC8"><br></div>
<div class="line" id="LC9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserSubmit").click(function(){</div>
<div class="line" id="LC10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#UserPassword").attr('value','');</div>
<div class="line" id="LC11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
<div class="line" id="LC13">&nbsp;&nbsp;&nbsp;&nbsp;});</div>
<div class="line" id="LC14">&lt;/script&gt;</div>
<div class="line" id="LC15"><br></div>
<div class="line" id="LC16">&lt;div class="panel left"&gt;</div>
<div class="line" id="LC17">&nbsp;&nbsp;&nbsp;&nbsp;&lt;h2 class="headings"&gt;Account Login&lt;/h2&gt;</div>
<div class="line" id="LC18">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;create('User',</div>
<div class="line" id="LC19">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(</div>
<div class="line" id="LC20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'class'=&gt;'form-panel'</div>
<div class="line" id="LC21">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)); ?&gt;</div>
<div class="line" id="LC22">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;input('User.primary_email'); ?&gt;</div>
<div class="line" id="LC23">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;input('User.password'); ?&gt;</div>
<div class="line" id="LC24">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php</div>
<div class="line" id="LC25">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;echo $this-&gt;Form-&gt;input('User.hash',</div>
<div class="line" id="LC26">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;array(</div>
<div class="line" id="LC27">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'before'=&gt;"&lt;div style=\"display:none\"&gt;",</div>
<div class="line" id="LC28">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'after'=&gt;'&lt;/div&gt;')</div>
<div class="line" id="LC29">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;);</div>
<div class="line" id="LC30">&nbsp;&nbsp;&nbsp;&nbsp;?&gt;</div>
<div class="line" id="LC31">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;end('Login',array('id'=&gt;'UserSubmit')); ?&gt;</div>
<div class="line" id="LC32">&lt;/div&gt;('User.primary_email'); ?&gt;</div>
<div class="line" id="LC33">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;input('User.password'); ?&gt;</div>
<div class="line" id="LC34">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;input('User.hash',array('type'=&gt;'hidden')); ?&gt;</div>
<div class="line" id="LC35">&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php echo $this-&gt;Form-&gt;end('Login',array('id'=&gt;'UserSubmit')); ?&gt;</div>
<div class="line" id="LC36">&lt;/div&gt;</div>
</pre>

<p>Shortly after I implemented this solution I finally figured out <a href="http://book.cakephp.org/view/1297/Configuration" target="_blank">configuration options</a>; they need to be set in beforeFilter (I was trying to set them as form options). Setting $disableFields will allow you to ignore specified fields.</p>

<pre>
<div class="line" id="LC1">&lt;?php</div>
<div class="line" id="LC2">&nbsp;&nbsp;&nbsp;&nbsp;function beforeFilter(){</div>
<div class="line" id="LC3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parent::beforeFilter();</div>
<div class="line" id="LC4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;Security-&gt;disabledFields = array('User.hash');</div>
<div class="line" id="LC5">&nbsp;&nbsp;&nbsp;&nbsp;}</div>
<div class="line" id="LC6">?&gt;</div>
</pre>




