<?php

/**
 * Returns the content of page
 *
 * @return string html for page render
 * @author Konstantin Kudryashov <ever.zet@gmail.com>
 **/
function makePage($uri)
{
  $retVar = sprintf(<<<EOF
<!DOCTYPE html>
<html>
  <head>
	<style type="text/css">
		%s
	</style>
  </head>
  <body onLoad="load()">
	<iframe name="help" src="%s"></iframe>

    <script type="text/javascript">
      function load() {
		var frm = frames['help'].document;
		var otherhead = frm.getElementsByTagName("head")[0];
		var link = frm.createElement("link");
		link.setAttribute("rel", "stylesheet");
		link.setAttribute("type", "text/css");
		link.setAttribute("href", "/css/print.css");
		otherhead.appendChild(link);
      }
    </script>
  </body>
</html>
EOF
    , 'body{overflow:hidden;padding:0px;margin:0px;} iframe{border:0px;width:100%;height:100%;}'
    , $uri
  );
  
  return $retVar;
}