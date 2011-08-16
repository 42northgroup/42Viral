<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>

<?php if(defined('GOOGLE_SET_ACCOUNT')): ?>
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', '<?php echo GOOGLE_SET_ACCOUNT; ?>']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>  
<?php endif; ?>
    
<?php if(defined('GOOGLE_SET_ACCOUNT')): ?>   
    <meta name="google-site-verification" content="<?php echo GOOGLE_SITE_VERIFICATION ?>" />
<?php endif; ?> 