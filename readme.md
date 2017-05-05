
禁用右键: 把这个方法在页面head 里面就可以了

<script> 

function stop(){ return false; } 

document.oncontextmenu=stop; 

</script> 



/**
 * php中删除文件有一个系统函数
 
 * 参数$filename 表示文件的路径，可以是相对路径也可以是绝对路径
 
 * unlink ( string $filename  )
 
 * 列如，当前目录下有个文件：test.html
 
 * 可以执行   unlink ( 'test.html' );来删除
 
 * 另外删除目录用函数：rmdir()；用法与unlink ()相同
 
 */
 
//unlink ( 'ts.txt' );




/**

 * 假设需要删除一个名叫"upload"目录下的所有文件（但无需删除目录文件夹）
 
 */
 
//delFileUnderDir( 'upload');

/**

 * 仅删除指定目录下的文件，不删除目录文件夹
 
 */
 
function delFileUnderDir( $dirName )

{

    if ( $handle = opendir( "$dirName" ) ) {
    
        while ( false !== ( $item = readdir( $handle ) ) ) {
        
            if ( $item != "." && $item != ".." ) {
            
                if ( is_dir( "$dirName/$item" ) ) {
                
                    delFileUnderDir( "$dirName/$item" );
                    
                } else {
                
                    if( unlink( "$dirName/$item" ) ) {
                    
                        echo "成功删除文件： $dirName/$item \n";
                        
                    }
                    
                }
                
            }
            
        }
        
        closedir( $handle );
        
    }
    
}



/**

 * 删除目录及目录下的所有文件
 
 * 循环删除目录和文件函数
 
 */
 
 
function delDirAndFile( $dirName )

{

    if ( $handle = opendir( "$dirName" ) ) {
    
        while ( false !== ( $item = readdir( $handle ) ) ) {
        
            if ( $item != "." && $item != ".." ) {
            
                if ( is_dir( "$dirName/$item" ) ) {
                
                    delDirAndFile( "$dirName/$item" );
                    
                } else {
                
                    if( unlink( "$dirName/$item" ) ) {
                    
                        echo "成功删除文件： $dirName/$item \n";
                        
                    }
                    
                }
                
            }
            
        }
        
        closedir( $handle );
        
        if( rmdir( $dirName ) ) {
        
            echo "成功删除目录： $dirName \n";
            
        }
        
    }
    
}


/**
 * 获取本文件目录的文件夹地址$hostdir
 
 * 获取也就是扫描文件夹内的文件及文件夹名存入数组 $filesnames
 
 */
 
/* 

$hostdir=dirname(__FILE__);

$filesnames = scandir($hostdir);

foreach ($filesnames as $name) {

    $url="http://www.****.com//".$name;
    
    $aurl= "<a href=\"".$url."\">".$url."</a>";
    
    echo $aurl . "<br/>";
    
    
}  


*/




/**

 * 打开一个目录,并继续阅读其内容
 
 * @var unknown
 
 */
 
/* 

$dir = "D:/phpStudy/WWW/qx/";

if (is_dir($dir)) {

    if ($dh = opendir($dir)) {
    
        while (($file = readdir($dh)) !== false) {
        
            echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
            
        } 
        
        closedir($dh);
        
    }
    
} 


*/


/**

 * 读取当前文件目录下所有文件，子目录文件
 
 * @param unknown $path
 
 * @param unknown $data
 
 */
 
 
function searchDir($path,&$data){

    if(is_dir($path)){
    
        $dp=dir($path);
        
        while($file=$dp->read()){
        
            if($file!='.'&& $file!='..'){
            
                searchDir($path.'/'.$file,$data);
                
            }
            
        }
        
        $dp->close();
        
    }
    
    if(is_file($path)){
    
        $data[]=$path;
        
    }
    
}



function getDir($dir){

    $data=array();
    
    searchDir($dir,$data);
    
    return   $data;
    
}


//print_r(getDir('.'));



/* 


if(!function_exists('read_pdf')) {

    function read_pdf($file) {
    
        if(strtolower(substr(strrchr($file,'.'),1)) != 'pdf') {
        
            echo '文件格式不对.';
            
            return;
            
        }
        
        if(!file_exists($file)) {
        
            echo '文件不存在';
            
            return;
            
        }
        
        header('Content-type: application/pdf');
        
        header('filename='.$file);
        
        readfile($file);
        
    }
    
}

read_pdf('Java.pdf');

*/

/*


$fp = fopen("Java.pdf", "r");


header("Content-type: application/pdf");


fpassthru($fp);


fclose($fp); 


*/

//echo getPageTotal('py43.pdf');


/**

 * 获取PDF的页数
 
 */
 
 
function getPageTotal($path){

    // 打开文件
    
    if (!$fp = @fopen($path,"r")) {
    
        $error = "打开文件{$path}失败";
        
        return false;
        
    } else {
    
        $max=0;
        
        while(!feof($fp)) {
        
            $line = fgets($fp,255);
            
            if (preg_match('/\/Count [0-9]+/', $line, $matches)){
            
                preg_match('/[0-9]+/',$matches[0], $matches2);
                
                if ($max<$matches2[0]) $max=$matches2[0];
                
            }
            
        }
        
        fclose($fp);
        
        // 返回页数
        
        return $max;
        
    }
    
}




/**************************************分隔线***PDF转txt******start******************************************************/

/**

 * pdf转txt
 
 */
 
header("Content-Type: text/html;charset=utf-8");


if (empty($page)) {

    $page = 1;
    
}

if (isset($_GET['page']) == TRUE) {

    $page = $_GET['page']; 
    
}

/**

 * 计算中文字符串长度
 
 */
 
 
function utf8_strlen($string = null) {

    // 将字符串分解为单元
    
    preg_match_all("/./us", $string, $match);
    
    // 返回单元个数
    
    return count($match[0]);
    
}


/**
 * 
 
 * @param $str 数据
 
 * @param $start 开始长度
 
 * @param $len 总长度
 
 * @return string
 
 */
 
 
function msubstr($str, $start, $len) {

    $strlength = $start + $len;
    
    $tmpstr = "";
    
    for($i = 0; $i < $strlength; $i++) {
    
        //ord() 函数返回字符串的首个字符的 ASCII 值
        
        if(ord(mb_substr($str, $i, 1, 'utf-8')) == 0x0a) {
        
            $tmpstr .= '<br />';
            
        }
        
        if(ord(mb_substr($str, $i, 1, 'utf-8')) > 0xa0) {
        
            $tmpstr .= mb_substr($str, $i, 2, 'utf-8');
            
            $i++;
            
        } else{
        
            $tmpstr .= mb_substr($str, $i, 1, 'utf-8'); 
            
        }
        
    }
    
    return $tmpstr;
    
}


if($page){

    $filename = 'p5pc.pdf';
    
    $content = shell_exec('/usr/local/bin/pdftotext -layout -enc GBK '.$filename.' -');
    
    $content = mb_convert_encoding($content, 'UTF-8','GBK');
    
    file_put_contents('p5pc.txt', $content);
    
    $length = utf8_strlen($content);
    
    $page_count = ceil($length / 500);
    
    
    //------------截取中文字符串---------
    
    $one = msubstr($content, 0, ($page - 1) * 500);
    
    $two = msubstr($content, 0, $page * 500);
    
    
    echo mb_substr($two, utf8_strlen($one), utf8_strlen($two)-utf8_strlen($one), 'utf-8');
    
    
    echo "<a href=demo.php?page=1>首页</a> ";
    
    if($page != 1) {
    
        echo "<a href=newfile.php?page=".($page-1).">上一页</a> ";
        
    }
    
    if($page < $page_count) {
    
        echo "<a href=newfile.php?page=".($page+1).">下一页</a> ";
        
    }
    
    echo "<a href=demo.newfile?page=".$page_count.">尾页</a>";
    
    
    echo $page.'/';
    
    echo $page_count.'页';
    
}


/**************************************分隔线***PDF转txt******end******************************************************/


/**************************************分隔线***txt********start****************************************************/


if (empty($page)) {

    $page=1;
    
}

if (isset($_GET['page']) == TRUE) {

    $page = $_GET['page']; 
    
}



if($page) {

    $content = file_get_contents("example.txt"); //读取txt文件内容
    
    $length = utf8_strlen($content);
    
    $page_count = ceil($length / 500);
    

    //------------截取中文字符串---------
    
    $one = msubstr($content,0,($page-1)*500);
    
    $two = msubstr($content,0,$page*500);
    
    echo mb_substr($two, utf8_strlen($one), utf8_strlen($two) - utf8_strlen($one), 'utf-8');
    
    echo "<a href=demo.php?page=1>首页</a> ";
    
    if($page != 1) {
    
        echo "<a href=demo.php?page=".($page-1).">上一页</a> ";
        
    }
    
    if($page < $page_count) {
    
        echo "<a href=demo.php?page=".($page+1).">下一页</a> ";
        
    }
    
    echo "<a href=demo.php?page=".$page_count.">尾页</a>";
    
    
    echo $page.'/';
    
    echo $page_count.'页';
    
}


/**************************************分隔线***txt********end****************************************************/
