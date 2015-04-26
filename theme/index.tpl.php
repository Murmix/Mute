<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
  <meta charset='utf-8'/>
  <title><?=get_title($title)?></title>
  <?php foreach($stylesheets as $val): ?>
    <link rel='stylesheet' type='text/css' href='<?=$val?>'/>
  <?php endforeach; ?>  
  <?php if(isset($favicon)): ?><link rel='shortcut icon' href='<?=$favicon?>'/><?php endif; ?>
  <?php if(isset($modernizr)): ?><script src='<?=$modernizr?>'></script><?php endif; ?>
</head>
<body>
  <div id='wrapper'>
    <div id='header'>
      <img class='sitelogo' src='img/speaker.png' alt='Mute Logo'/>
      <span class='sitetitle'><?=$title?></span>
      <span class='siteslogan'><strong>Mu</strong>rmix&#9733;Templa<strong>te</strong></span>
    </div>
    <?php echo CNavigation::GenerateMenu($topmenu, 'top-menu'); ?>      
    <div id='main'><?=$main?></div>
    <div id='footer'>
      <footer>Copyright &copy; 2015. Powered by Mute: Murmix&#9733;Template. <a href="https://github.com/Murmix/Mute">Mute on GitHub</a></footer>
    </div>
  </div>
  <div style="display:none;"><p><code>$_SESSION</code> innehåller följande:</p><pre><?php print_r($_SESSION); ?></pre></div>
  <?php if(isset($jquery)):?><script src='<?=$jquery?>'></script><?php endif; ?>
  <?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
    <script src='<?=$val?>'></script>
  <?php endforeach; endif; ?>
  <?php if(isset($google_analytics)): ?>  
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', '<?=$google_analytics?>', 'auto');
    ga('send', 'pageview');
  </script>  
  <?php endif; ?>  
</body>
</html>
