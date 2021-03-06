<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

//Initialize configuration variables
//I like this model because it forces us to look at what we are working with
$titleForLayout = $title_for_layout;

$canonical_for_layout = View::getVar('canonical_for_layout');
$canonicalForLayout = isset($canonical_for_layout)?$canonical_for_layout:$this->here;

$googleSetAccount = Configure::read('Google.setAccount');
$googleSiteVerification = Configure::read('Google.SiteVerification');


echo $this->Html->charset(); 
echo $this->Html->tag('title', $titleForLayout);
echo "<link rel=\"canonical\" href=\"{$canonicalForLayout}\" />";

// Inject Google site verification meta tags
// <meta name="google-site-verification" content="cnyutvkbvjlhbsdfvshbflbfdljhb">
if(is_array($googleSiteVerification)):
    for($i=0; $i<count($googleSiteVerification); $i++):
        echo $this->Html->meta(array('name' => 'google-site-verification', 'content' => $googleSiteVerification[$i])); 
    endfor;
endif;

?> 

<?php if(isset($googleSetAccount)): ?>
    <!-- Google Analytics -->
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo $googleSetAccount; ?>']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>  
<?php endif; ?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">