方法一：利用php com模块。也即利用word提供的本地api，所有只适用于windows系统上

    <?php  
    
    $word = new com('word.application') or die('无法打开word');  
    
    $word->Visiable = false;  
    
    $doc_file = '/path/to/doc';  
    
    $word->Open($doc_file);  
    
    $text = '这段文字将被写到word文档中去';  
    
    $word->Selection->TypeText($text);  
    
    //保存  
    
    $word->ActiveDocument->Save();  
    
    //读取内容  
    
    $doc_file_contents = $word->ActiveDocument->Content->Text;  
    
    //输出word内容  
    
    $word->PrintOut();  
    
    $word->Close();  
    
    ?>  
    
    
    方法二：利用catdoc。catdoc是Linux上的工具，需要自行安装配置。
    
    <?php  
    
//catdoc位置  

$cat_doc = '/usr/local/bin/catdoc'; 

$doc_file = 'this is a doc file';  

//读取word文件内容  

$doc_file_contents = shell_exec($cat_doc . ' ' . $doc_file);   

echo nl2br($doc_file_contents);  
由于catdoc是linux的工具，所以上面的这段代码只能运行在linux服务器上，而已必须安装了catdoc
?>
