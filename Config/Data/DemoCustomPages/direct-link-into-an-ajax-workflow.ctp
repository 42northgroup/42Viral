<!-- Jason Snider August 14, 2010 -->

<p style="font-style:italic;">*Note: While this tutorial offers functional code, the solution is less than ideal. This is intended to get you thinking about the problem and some potential ideas for a solution. I will follow this post up with a production worthy solution.</p>

<p>
AJAX is great way to build seamless work flows and speed up your web application by eliminating the number of post backs needed to complete a given task. Despite it's reduction of overhead, AJAX is not with out it's problems. One of the biggest pitfalls is the URL.
</p>

<p>
Since AJAX isn't doing a post back, bookmarking any step of the process will give you a URL that starts at the beginning of the work flow rather than the piece your trying to get back to. This causes issues with both search engines and trouble tickets. The search engine may try to serve URLs that make no since from a direct access point of view. Trouble tickets have a similar problem in that the user reporting an issue isn't able to send a direct link to the troubled piece of the work flow. From the point of view of an ideal work flow you'll hit a page and perform a series of AJAX requests to complete a task. As we have mentioned, this can lead to a trade off usability vs. performace, however there are solutions.
</p>

<p>I am currently working on a system to handle trouble tickets. The design is simple; show a list of tickets on the left, clicking an edit link on any given ticket will display that ticket on the right. I want the system to be as fast as possible so ran some test loading the right hand column via AJAX against via post back. AJAX was considerably faster, this does however present on problem, the URL. I need to be able to link to any single ticket in the system, but my work flow starts at the index so all of my links will start at the index instead of the target ticket, right? Well yeah, but there is a workaround that will allow us to direct link any step of our work flow.</p>

<p>The work around starts with understanding your infrastructure. I tend to build on top of CakePHP and JQuery so we will use these as examples. Lets start with JQuery's AJAX request.</p>

<p>The way I like to build AJAX links is by building a standard html link. Often in an AJAX application you'll see the anchor tag's href attribute populated with "javascript:[...];" or "#[...]" as a way of preventing post and invoking an AJAX method but I prefer my hrefs populated with a proper URL (This using this can allow for concepts such as fallback mode for non-javascript users). I'll place an event listener on that element. When the onclick event is caught, I'll disable the default post back and pass the href value into the AJAX call. In the case the of my ticketing system, I'm building a table of tickets with an actions row in each column, clicking the edit link will load a ticket the left hand column. JQuery's delegate function is ideal for applying our listeners in this case.</p>

<p>Our link generation may look something like this.</p>
<script src="http://gist.github.com/524447.js?file=Link%20Generation"></script><link rel="stylesheet" href="https://gist.github.com/stylesheets/gist/embed.css"><div id="gist-524447" class="gist">






      <div class="gist-file">
        <div class="gist-data gist-syntax">



            <div class="gist-highlight"><pre><div class="line" id="LC1">&lt;table class="widget-data"&gt;</div><div class="line" id="LC2">	&lt;?php $i=0; foreach($tickets as $ticket): ?&gt;</div><div class="line" id="LC3">		&lt;tr class="&lt;?php echo $i%2==0?'even-row':'odd-row'; $i++; ?&gt;"&gt;</div><div class="line" id="LC4">		&lt;td id="TitleCell_&lt;?php echo $ticket['Ticket']['id']; ?&gt;"&gt;</div><div class="line" id="LC5">		    &lt;?php echo $ticket['Ticket']['title']; ?&gt;</div><div class="line" id="LC6">		&lt;/td&gt;</div><div class="line" id="LC7"><br></div><div class="line" id="LC8">		&lt;td id="StatusCell_&lt;?php echo $ticket['Ticket']['id']; ?&gt;"&gt;</div><div class="line" id="LC9">		    &lt;?php echo $ticket_statuses[$ticket['Ticket']['ticket_status_id']]; ?&gt;</div><div class="line" id="LC10">		&lt;/td&gt;</div><div class="line" id="LC11"><br></div><div class="line" id="LC12">		&lt;td&gt;</div><div class="line" id="LC13">		/* The anchor tag, assuming if I had a ticket with an id of 7 this would</div><div class="line" id="LC14">	         * produce a URL like "/admin_tickets/view/7"</div><div class="line" id="LC15">		 */</div><div class="line" id="LC16">		&lt;?php</div><div class="line" id="LC17">		    echo $this-&gt;Html-&gt;link(</div><div class="line" id="LC18">				'Edit',</div><div class="line" id="LC19">				"/admin_tickets/view/{$ticket['Ticket']['id']}",</div><div class="line" id="LC20">				array('class'=&gt;'ticket-link')</div><div class="line" id="LC21">			    );</div><div class="line" id="LC22">		?&gt;</div><div class="line" id="LC23">		&lt;/td&gt;</div><div class="line" id="LC24">		&lt;/tr&gt;</div><div class="line" id="LC25"><br></div><div class="line" id="LC26">		&lt;?php endforeach; ?&gt;</div><div class="line" id="LC27">	&lt;/table&gt;</div><div class="line" id="LC28">&lt;/div&gt;</div></pre></div>

        </div>

        <div class="gist-meta">
          <a href="https://gist.github.com/raw/524447/77de63b7f79b82e5f091353caf98a1391a9d1ff1/Link%20Generation" style="float:right;">view raw</a>
          <a href="https://gist.github.com/524447#file_link generation" style="float:right;margin-right:10px;color:#666">Link Generation</a>
          <a href="https://gist.github.com/524447">This Gist</a> brought to you by <a href="http://github.com">GitHub</a>.
        </div>
      </div>




</div>


<p>Our delegation of event listeners may look like this.</p>
<script src="http://gist.github.com/524447.js?file=Original%20View"></script><link rel="stylesheet" href="https://gist.github.com/stylesheets/gist/embed.css"><div id="gist-524447" class="gist">







      <div class="gist-file">
        <div class="gist-data gist-syntax">



            <div class="gist-highlight"><pre><div class="line" id="LC1">&lt;script type="text/javascript"&gt;</div><div class="line" id="LC2">&nbsp;&nbsp;&nbsp;&nbsp;$(function(){</div><div class="line" id="LC3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class="line" id="LC4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#tickets").delegate(".ticket-link", "click", function(){</div><div class="line" id="LC5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;var ticketUrl = $(this).attr('href');</div><div class="line" id="LC6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$.ajax({</div><div class="line" id="LC7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;url: ticketUrl,</div><div class="line" id="LC8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;success: function(html) {</div><div class="line" id="LC9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$('#Ticket').html(html);</div><div class="line" id="LC10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</div><div class="line" id="LC11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC12"><br></div><div class="line" id="LC13">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return false;</div><div class="line" id="LC14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC15">&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC16">&lt;/script&gt;</div></pre></div>

        </div>

        <div class="gist-meta">
          <a href="https://gist.github.com/raw/524447/e06c0f61982de0099520dc91468038409923871a/Original%20View" style="float:right;">view raw</a>
          <a href="https://gist.github.com/524447#file_original view" style="float:right;margin-right:10px;color:#666">Original View</a>
          <a href="https://gist.github.com/524447">This Gist</a> brought to you by <a href="http://github.com">GitHub</a>.
        </div>
      </div>



</div>


<p>In my MVC application (using the CakePHP framework) I am accessing the admin_tickets controller. Here I am focused on two actions, index and view. Index is the action that is called upon the initial post back. Traditionally, my URL would change from /admin_tickets to /admin_tickets/view/7 and when I want to view ticket 7 I could just call /admin_tickets/view/7. Since viewing the ticket is the second step of my work flow, book marking this will simply return me to the index view (or step one of my work flow). I could do something like "right click" and "copy link" or "right click" and "Open in new tab", but these would just render broken views. So how do we have a URL that open a specific ticket instead of the index view or first stage of the work flow? Simple, understand whats going to break and prepare for it.</p>

<p>Making a post back to /admin_tickets/view/7 will render a broken view, but only if the controller action is not expecting a post back request. So we'll use the first line of the controller action to test for a post back request.</p>

<p>What we want to do is to tell our index action that we want to make an AJAX request to the view action and pass a specific id (in our example; 7) into the view action. </p>
<script src="http://gist.github.com/524447.js?file=Controller%20Logic%20with%20URL%20work%20around"></script><link rel="stylesheet" href="https://gist.github.com/stylesheets/gist/embed.css"><div id="gist-524447" class="gist">





      <div class="gist-file">
        <div class="gist-data gist-syntax">



            <div class="gist-highlight"><pre><div class="line" id="LC1">&lt;?php</div><div class="line" id="LC2">##Controller Action  </div><div class="line" id="LC3">&nbsp;&nbsp;</div><div class="line" id="LC4">function view($id){</div><div class="line" id="LC5">&nbsp;&nbsp;&nbsp;//Test for an AJAX request</div><div class="line" id="LC6">&nbsp;&nbsp;&nbsp;if(!$this-&gt;params['isAjax']){</div><div class="line" id="LC7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;//If it's not an AJAX request build a redirect</div><div class="line" id="LC8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$this-&gt;redirect("/admin_tickets/index/action:view/id:{$this-&gt;params['pass'][0]}");</div><div class="line" id="LC9">&nbsp;&nbsp;&nbsp;}</div><div class="line" id="LC10">&nbsp;&nbsp;&nbsp;##[Rest of controller logic...]</div><div class="line" id="LC11">}</div><div class="line" id="LC12">?&gt;</div></pre></div>

        </div>

        <div class="gist-meta">
          <a href="https://gist.github.com/raw/524447/fcff5e60d199c301b441a32e408231d10004cb9b/Controller%20Logic%20with%20URL%20work%20around" style="float:right;">view raw</a>
          <a href="https://gist.github.com/524447#file_controller logic with url work around" style="float:right;margin-right:10px;color:#666">Controller Logic with URL work around</a>
          <a href="https://gist.github.com/524447">This Gist</a> brought to you by <a href="http://github.com">GitHub</a>.
        </div>
      </div>





</div>


<p>Now we all have to do is tell the index view what to do if it sees an action and id parameter. This is covered in the first control statement seen below. What we are doing here is building the same URL we would be passing by clicking the edit link, only this time we are passing that URL as soon as the DOM is ready.</p>
<script src="http://gist.github.com/524447.js?file=View%20with%20work%20around%20detection"></script><link rel="stylesheet" href="https://gist.github.com/stylesheets/gist/embed.css"><div id="gist-524447" class="gist">








      <div class="gist-file">
        <div class="gist-data gist-syntax">



            <div class="gist-highlight"><pre><div class="line" id="LC1">&lt;script type="text/javascript"&gt;</div><div class="line" id="LC2">&nbsp;&nbsp;&nbsp;&nbsp;$(function(){</div><div class="line" id="LC3"><br></div><div class="line" id="LC4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php</div><div class="line" id="LC5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;if(isset($this-&gt;params['named']['action'])):</div><div class="line" id="LC6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$url = "/admin_tickets/{$this-&gt;params['named']['action']}/{$this-&gt;params['named']['id']}";</div><div class="line" id="LC7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;?&gt;</div><div class="line" id="LC8">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$.ajax({</div><div class="line" id="LC9">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;url: '&lt;?php echo $url; ?&gt;',</div><div class="line" id="LC10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;success: function(html) {</div><div class="line" id="LC11">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$('#Ticket').html(html);</div><div class="line" id="LC12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</div><div class="line" id="LC13">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC14">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;?php endif; ?&gt;</div><div class="line" id="LC15"><br></div><div class="line" id="LC16">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div><div class="line" id="LC17">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$("#tickets").delegate(".ticket-link", "click", function(){</div><div class="line" id="LC18">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;var ticketUrl = $(this).attr('href');</div><div class="line" id="LC19">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$.ajax({</div><div class="line" id="LC20">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;url: ticketUrl,</div><div class="line" id="LC21">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;success: function(html) {</div><div class="line" id="LC22">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$('#Ticket').html(html);</div><div class="line" id="LC23">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;}</div><div class="line" id="LC24">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC25"><br></div><div class="line" id="LC26">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;return false;</div><div class="line" id="LC27">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC28">&nbsp;&nbsp;&nbsp;&nbsp;});</div><div class="line" id="LC29">&lt;/script&gt;</div><div class="line" id="LC30"><br></div><div class="line" id="LC31">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></pre></div>

        </div>

        <div class="gist-meta">
          <a href="https://gist.github.com/raw/524447/93fca5bb132ce9d1fb51408334733cb883459430/View%20with%20work%20around%20detection" style="float:right;">view raw</a>
          <a href="https://gist.github.com/524447#file_view with work around detection" style="float:right;margin-right:10px;color:#666">View with work around detection</a>
          <a href="https://gist.github.com/524447">This Gist</a> brought to you by <a href="http://github.com">GitHub</a>.
        </div>
      </div>


</div>


<p>Now we have a link we can send to people and it will have specified ticket opened by default. I would recommend generating a URL and always displaying that in the view you want to direct link to. Perhaps even a bit of clipboard logic?</p>

<p>While this approach does work, it could be better, but hopefully this will you a logical starting point and get you thinking about the pitfalls of linking into an AJAX application. We'll call this a conversation starter. In future articles we'l talk about using the hash tags and building a more robust solution. </p>

<h2>Related Links</h2>
<a href="http://api.jquery.com/delegate/">JQuery Delegate</a><br>
<a href="http://api.jquery.com/jQuery.ajax/">JQuery AJAX</a><br>
<a href="http://cakephp.org/">CakePHP</a>