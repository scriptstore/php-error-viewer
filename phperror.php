<?php
/*
PHP error log viewer and analyzor
programming by Moahhamad ali abbaspor
website : www.4vip.ir
cell : 09370071083
email : 4vip.abbaspor@gmail.com
this is free for all
*/

// config start
$password = "bitsoft";
$RowCount = 25;
$FatalColor = "#eb6a6a";
$NoticColor = "#70e66e";
$WarningColor = "#e0eb46";
$ParseColor = "#7796d9";

$PhpErrorFile = "error_log";

$HtmlHeader = <<< CODE
<!DOCTYPE html>
<html>
<head>
<title>PHP error viewer | Mohammad ali abbaspor | 09370071083</title>
<meta charset="utf-8">
<script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
<style>
a {text-decoration: none; }
</style>
</head>
<body>
CODE;

$HtmlFooter = <<< CODE
</body>
</html>
CODE;

// config end

session_start();

if (isset($_POST["action"]))
{
    switch ($_POST["action"])
    {
        case "login":
            CheckLogin();
            exit();
            break;
        case "all":
        case "home":
            LoadTable();
            exit();
            break;
        case "aboutme":
            AboutMe();
            exit();
            break;
        case "exit":
            ExitUser();
            exit();
            break;
    }

}

if (isset($_SESSION["login"]) && ($_SESSION["login"] == false) && (!$_POST && !
    isset($_POST["action"])))
{
    LoginForm();
} else
{
    Dashbroard();
}

function CheckLogin()
{
    global $password;
    if ($_POST["password"] == $password)
    {
        $_SESSION["login"] = true;
        Dashbroard();
    } else
    {
        echo "Password wrong!";
        $_SESSION["login"] = false;
    }


}

function AboutMe()
{
    $ali = <<< CODE
/9j/4AAQSkZJRgABAQEAlgCWAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0a HBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIy MjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCADtALEDASIA AhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQA AAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3 ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWm p6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEA AwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSEx BhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElK U1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3 uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iii gAooooAKKKKAENFNkdUUsxAA5JPavPfFnxS0/SFa20xkurrH3wfkU/1PtUTmo7lRg5PQ7fUdUstL gM97cxwRj+J2xn6V55rXxjsbWR4dNtTcMvG+Q7R+X/6q8l1XxDe6pcSXN5O8kh5+Zsn6Adh7VgSX e7O5sZ/hXpWV6kt9DdQhHzPUJPjDrsk2UW0Rf7ojJ/z+dX7T4y36AC4s7SbHUqWQ/wAz/KvGhKGI 9O1TbyEI3Yp8jXVi5ovoe+2Pxm0afaLuzubcngsuHUfyP6V1+neL9A1TH2XVrVieQpcK35GvlJSd n31/E0K9wrggfiMkU033E4wfQ+yEdXUMpBU9CDmn18zeD/H2q+HrqKMzPNZA/vLeQ5XHcg9jX0lZ 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 
CODE;

    $image = '<a href="http://4vip.ir/"><img ' . 'src="data:image/jepg;base64,' . $ali .
        '" alt="Mohammad ali abbaspor" />';
    $HtmlCode = <<< CODE
<p>
Hello<br>
PHP error viewer<br>
Version : 0.1<br>
Date : 10/02/2015<br>
Programming language : PHP + JQUERY + AJAX + HTML5<br>
Description : PHP error viewer is a tools for view and analyze php error log files. Copy this file next to the file error_log. and open with browser.<br><br>
my name is mohammad ali abbaspor. i live in iran. i am a PHP developer.<br>
my website : <a href="http://4vip.ir/">4vip.ir</a><br>
my mobile  : 0989370071083<br>
my email   : 4vip.abbaspor@gmail.com<br><br>
$image
</p>  
CODE;
    echo $HtmlCode;
}


function LoginForm()
{
    global $HtmlHeader, $HtmlFooter;

    $HtmlCode = <<< CODE
    <style>
    
    #Login {
	width: 400px;
	height: 50px;
	

	position: absolute;
	top:0;
	bottom: 0;
	left: 0;
	right: 0;
	
	margin: auto;
    border:1px solid black;
    }
    </style>
    <div id="Login"><center>
    <form method='post' name="login" action='#' id="loginform">
Login password : <input  id="password" name="password" type="password"  />
<input id="submit" name="submit" type="submit" value="Login" />
</form>
<span></span> 
</center>
</div>
<script language="javascript">
//$('body').empty();
$('#loginform').submit(function(event) {
    if($("#password").val()=="" )
	{
		alert("Please enter your password.");
		return false;
    } 
    
    postdata = $(this).serialize();
    postdata += "&action=login";
    
    $.ajax({
    url: 'phperror.php',
    data: postdata,
    type: 'post',
    success: function(data) {
        if (data == "Password wrong!" )
            {
                alert (data);
                return false;
            } else {
                $('body').empty();
                $('body').prepend(data);        
            }
        
    }
    }); 
    
    event.preventDefault();
     });
 </script>
CODE;

    echo $HtmlHeader;
    echo $HtmlCode;
    echo $HtmlFooter;
}

function ExitUser()
{
    $_SESSION["login"] = false;
    LoginForm();
}
function LoadTable()
{
    global $FatalColor, $NoticColor, $WarningColor, $ParseColor, $RowCount, $PhpErrorFile;
    $i = 0;

    $file = fopen($PhpErrorFile, "r");

    if ($_POST['action'] == "all")
    {
        while (!feof($file))
        {
            $read[] = fgetss($file);
        }
    } else
    {
        while ($i <= $RowCount)
        {
            if (feof($file)) break;

            $read[] = fgets($file);

            $i++;
        }
    }

    $b = "";
    $table = <<< CODE
<a onclick="ajax('all');" href="#">Show all error file</a></ br><table id="datatable" border="1" style="text-align:center;width:100%">
<thead><tr bgcolor="Yellow"><th>Date</th><th>Time</th><th>Type</th><th>Error</th><th>Message</th></tr></thead>
<tbody><tr>
CODE;

    foreach ($read as $line)
    {
        $row = explode(" ", $line);
        $message = array_slice($row, 6);
        $message = implode(" ", $message);

        switch ($row[4])
        {
            case "Fatal":
                $color = $FatalColor;
                break;
            case "Notice:":
                $color = $NoticColor;
                break;
            case "Warning:":
                $color = $WarningColor;
                break;
            case "Parse":
                $color = $ParseColor;
                break;
        }

        $b .= "
    <tr bgcolor=\"$color\">
    <td>" . trim($row[0], "[") . "</td>
    <td>$row[1]</td>
    <td>$row[3]</td>
    <td>" . trim($row[4], ":") . "</td>
    <td>$message</td>
    </tr>";
    }

    $table .= $b . "</tbody></table>";
    echo $table;

    
}
function DashboardHtml()
{
    global $HtmlHeader, $HtmlFooter, $FatalColor, $NoticColor, $WarningColor, $ParseColor;


    $HtmlCode = <<< CODE
<div id="Dashboard">
<style>
    
    #Dashboard {
	width: 98%;
	height: 1000px;
	

	position: absolute;
	top:0;
	bottom: 0;
	left: 0;
	right: 0;
	
	margin: auto;
    border:1px solid black;
    }
.filter-table .quick { margin-left: 0.5em; font-size: 0.8em; text-decoration: none; }
.fitler-table .quick:hover { text-decoration: underline; }
td.alt { background-color: #e67f2c;}
    </style>
<div>
</ br>
<a id="loadtable" onclick="ajax('home');" href="#">Home</a> | 
<a onclick="ajax('aboutme');" href="#">About me</a> | 
<a onclick="ajax('exit');" href="#">Exit</a> |
<span style="background-color: $FatalColor;">Fatal error</span>
<span style="background-color: $WarningColor;">Warning error</span>
<span style="background-color: $ParseColor;">Parse error</span>
<span style="background-color: $NoticColor;">Notic error</span>
</ br><hr>
</div>
<div id="page"></div>
</div>
<script language="javascript">
!function($){var e=$.fn.jquery.split("."),t=parseFloat(e[0]),i=parseFloat(e[1]);$.expr[":"].filterTableFind=2>t&&8>i?function(e,t,i){return $(e).text().toUpperCase().indexOf(i[3].toUpperCase())>=0}:jQuery.expr.createPseudo(function(e){return function(t){return $(t).text().toUpperCase().indexOf(e.toUpperCase())>=0}}),$.fn.filterTable=function(e){var t={autofocus:!1,callback:null,containerClass:"filter-table",containerTag:"p",hideTFootOnFilter:!1,highlightClass:"alt",inputSelector:null,inputName:"",inputType:"search",label:"Search : ",minRows:8,placeholder:"search this table",preventReturnKey:!0,quickList:[],quickListClass:"quick",quickListGroupTag:"",quickListTag:"a",visibleClass:"visible"},i=function(e){return e.replace(/&/g,"&amp;").replace(/"/g,"&quot;").replace(/</g,"&lt;").replace(/>/g,"&gt;")},n=$.extend({},t,e),a=function(e,t){var i=e.find("tbody");""===t?(i.find("tr").show().addClass(n.visibleClass),i.find("td").removeClass(n.highlightClass),n.hideTFootOnFilter&&e.find("tfoot").show()):(i.find("tr").hide().removeClass(n.visibleClass),n.hideTFootOnFilter&&e.find("tfoot").hide(),i.find("td").removeClass(n.highlightClass).filter(':filterTableFind("'+t.replace(/(['"])/g,"\\$1")+'")').addClass(n.highlightClass).closest("tr").show().addClass(n.visibleClass)),n.callback&&n.callback(t,e)};return this.each(function(){var e=$(this),t=e.find("tbody"),l=null,s=null,r=null,o=!0;"TABLE"===e[0].nodeName&&t.length>0&&(0===n.minRows||n.minRows>0&&t.find("tr").length>n.minRows)&&!e.prev().hasClass(n.containerClass)&&(n.inputSelector&&1===$(n.inputSelector).length?(r=$(n.inputSelector),l=r.parent(),o=!1):(l=$("<"+n.containerTag+" />"),""!==n.containerClass&&l.addClass(n.containerClass),l.prepend(n.label+" "),r=$('<input type="'+n.inputType+'" placeholder="'+n.placeholder+'" name="'+n.inputName+'" />'),n.preventReturnKey&&r.on("keydown",function(e){return 13===(e.keyCode||e.which)?(e.preventDefault(),!1):void 0})),n.autofocus&&r.attr("autofocus",!0),$.fn.bindWithDelay?r.bindWithDelay("keyup",function(){a(e,$(this).val())},200):r.bind("keyup",function(){a(e,$(this).val())}),r.bind("click search",function(){a(e,$(this).val())}),o&&l.append(r),n.quickList.length>0&&(s=n.quickListGroupTag?$("<"+n.quickListGroupTag+" />"):l,$.each(n.quickList,function(e,t){var a=$("<"+n.quickListTag+' class="'+n.quickListClass+'" />');a.text(i(t)),"A"===a[0].nodeName&&a.attr("href","#"),a.bind("click",function(e){e.preventDefault(),r.val(t).focus().trigger("click")}),s.append(a)}),s!==l&&l.append(s)),o&&e.before(l))})}}(jQuery);
$("#loadtable").trigger("click");
function ajax(doaction){
$.ajax({
    url: 'phperror.php',
    data: {action: doaction},
    type: 'post',
    success: function(data) {
        
        if (doaction == "exit")
        {
             $('body').empty();
             $('body').prepend(data);
         }   
         if (doaction == "aboutme")
        {
             $('#page').html(data);
        }
        if (doaction == "home")
        {
             $('#page').html(data);
             $('table').filterTable();
        }
        if (doaction == "all")
        {
             $('#page').html(data);
             $('table').filterTable();
        }
    }
    });
}
     
    

    
 </script>	
CODE;

    echo $HtmlHeader;
    echo $HtmlCode;
    echo $HtmlFooter;

}
function Dashbroard()
{
    DashboardHtml();
}

?>
