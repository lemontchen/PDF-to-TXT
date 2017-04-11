<?php

    session_start();
    
    if (empty($page)) {$page=1;}
    
    if (isset($_GET['page'])==TRUE) {$page=$_GET['page']; }
    
?>

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Read Result</title>

<style type="text/css">

<!--

.STYLE1 {font-size: 12px}

.STYLE2 {font-size: 18px}



-->

</style>

</head>

<body>

<table width="100%"  bgcolor="#CCCCCC">

<tr>

<td >

<?php


// 计算中文字符串长度

function utf8_strlen($string = null) {

// 将字符串分解为单元

preg_match_all("/./us", $string, $match);

// 返回单元个数

return count($match[0]);

}


if($page){

$counter=file_get_contents("example.txt"); //读取txt文件内容到$counter

//$length=strlen($counter);

$length=utf8_strlen($counter);

$page_count=ceil($length/500);

//mb_substr( $str, $start, $length, $encoding ) 

//mb_substr($str,0,4,'utf-8');//

function msubstr($str,$start,$len){

    $strlength=$start+$len;
    
    $tmpstr="";
    
    for($i=0;$i<$strlength;$i++) {
    
    //if(ord(substr($str,$i,1))==0x0a) {
    
    //    $tmpstr.='<br />';
    
    //}
    
    //if(ord(substr($str,$i,1))>0xa0) {
    
    //   $tmpstr.=substr($str,$i,2);
    
    //    $i++;
    
    //}
    
    //else{
    
    //    $tmpstr.=substr($str,$i,1); }
    
	//ord() 函数返回字符串的首个字符的 ASCII 值
  
	if(ord(mb_substr($str,$i,1,'utf-8'))==0x0a) {
  
        $tmpstr.='<br />';
        
    }
    
    if(ord(mb_substr($str,$i,1,'utf-8'))>0xa0) {
    
        $tmpstr.=mb_substr($str,$i,2,'utf-8');
        
        $i++;
        
    }
    
    else{
    
        $tmpstr.=mb_substr($str,$i,1,'utf-8'); }
        
    }
    
    return $tmpstr;
    
}



//------------截取中文字符串---------

$c=msubstr($counter,0,($page-1)*500);

$c1=msubstr($counter,0,$page*500);

//echo substr($c1,strlen($c),strlen($c1)-strlen($c));

echo mb_substr($c1,utf8_strlen($c),utf8_strlen($c1)-utf8_strlen($c),'utf-8');

}?>

</td>

</tr>

</table>

<table width="100%"  bgcolor="#cccccc">

<tr>

<td width="42%" align="center" valign="middle">

<span class="STYLE1"> 

<?php echo $page;?>

/

<?php echo $page_count;?> 

页 

</span>

</td>

<td width="58%" height="28" align="left" valign="middle">

<span class="STYLE1">

<?php

echo "<a href=demo.php?page=1>首页</a> "; 

if($page!=1){

    echo "<a href=demo.php?page=".($page-1).">上一页</a> ";
    
}

if($page<$page_count){

    echo "<a href=demo.php?page=".($page+1).">下一页</a> ";
    
}

echo "<a href=demo.php?page=".$page_count.">尾页</a>"; 

?>

</span>

</td>

</tr>

</table>

</body>

</html>
