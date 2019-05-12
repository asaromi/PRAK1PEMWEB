<?php
    error_reporting(0);
    session_start();
    
    if (isset($_SESSION["user"]) && isset($_COOKIE["user"])){
        $dir = getcwd();
        if(isset($_GET['folder'])){
            $url = $_GET['folder'];
            $dir = getcwd()."/".$url;
            $urllength = strlen($url);
            $namedir = substr($dir,18,(strlen($dir)));
        } else {
            $url = "";
            $namedir = substr($dir,18,(strlen($dir)));
        }

        $dirlength = strlen($namedir);

        if($_POST['mkdir']){
            $newdir = $dir.'/'.$_POST['mkdir'];
            if(!file_exists($newdir)){
                mkdir($newdir, 0777);
            }
        }

        else if($_GET['duplicate']){
            $duplicate = $dir.'/'.$_GET['duplicate'];
            $fileType = pathinfo($duplicate, PATHINFO_EXTENSION);
            $oldfile = substr($duplicate,0,(strlen($duplicate)-(strlen($fileType)+1)));
            $newfile = $oldfile.'.backup.'.$fileType;
            copy($duplicate, $newfile);
            chmod($newfile,0777);
        } 

        else if($_GET['rmdir']){
            $rmdir = $dir.'/'.$_GET['rmdir'];
            if(file_exists($rmdir)){
                rmdir($rmdir);
            }
        }

        else if($_GET['rmfile']){
            $rmfile = $dir.'/'.$_GET['rmfile'];
            if(file_exists($rmfile)){
                unlink($rmfile);
            }
        }

        else{
            $tmp = $_FILES['upfile']['tmp_name'];
            $dir = $dir."/";
            $newfile = $_FILES['upfile']['name'];
            move_uploaded_file($tmp, $dir.$newfile);
        }
        
        

        function pretty_filesize($file) {
            $size = filesize($file);
            if($size < 1024){
                $size = $size." Bytes";
            } elseif(($size<1048576)&&($size>1023)){
                $size=round($size/1024, 1)." KB";
            } elseif(($size<1073741824)&&($size>1048575)){
                $size=round($size/1048576, 1)." MB";
            }else{
                $size=round($size/1073741824, 1)." GB";
            }
            return $size;
        }

        ?>
        <!DOCTYPE HTML>
        <html class="no-js" lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <title>Table Layout - srtdash</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
            <link rel="stylesheet" href="css/themify-icons.css">
            <link rel="stylesheet" href="css/metisMenu.css">
            <link rel="stylesheet" href="css/owl.carousel.min.css">
            <link rel="stylesheet" href="css/slicknav.min.css">
            <!-- amchart css -->
            <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
            <!-- others css -->
            <link rel="stylesheet" href="css/typography.css">
            <link rel="stylesheet" href="css/default-css.css">
            <link rel="stylesheet" href="css/styles.css">
            <!-- <link rel="stylesheet" href="css/responsive.css"> -->
            <!-- modernizr css -->
            <!-- <script src="js/modernizr-2.8.3.min.js" type="cd6086a0da2c33ebbcacb47a-text/javascript"></script> -->
        </head>

        <body>
            <!--[if lt IE 8]>
                    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
                <![endif]-->
            <!-- preloader area start -->
            <div id="preloader">
                <div class="loader"></div>
            </div>
            <!-- preloader area end -->
            <!-- page container area start -->
            <div class="page-container">
                <!-- main content area start -->
                <div class="content">
                    <!-- header area start -->
                    <div class="header-area">
                        <div class="row align-items-center" style="min-height : 50px;">
                            
                                <!-- page title area start -->
                                <div class="page-title-area" style="width : 100%">
                                    <div class="row align-items-left" style="width : 100%;">
                                        <div class="col-sm-6" style="width : 100%;">
                                            <div class="breadcrumbs-area clearfix" style="width : 100%;">
                                                <ul class="breadcrumbs pull-left" style="height: 50px; padding : 2px 0px; width : 100%;">
                                                    <!--harus diganti 
                                                        
                                                    <li><a href=#>Table Layout</a></li> 
                                                    <li><span>Table Layout</span></li> -->
                                                    <?php
                                                    if($_GET['folder']){
                                                        $rootdir = substr($namedir,0,$dirlength-($urllength+1));
                                                        $namedir = substr($namedir,($dirlength-$urllength),$urllength);
                                                        echo '<li><a href="index.php">'.$rootdir.'</a></li>';
                                                        echo '<li><span style="color: #768387; text-transform: lowercase;">'.$namedir.'</span></li>';
                                                    } else {
                                                        echo '<li><span style="color: #768387; text-transform: lowercase;">'.$namedir.'</span></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- page title area end -->
                            
                        </div>
                    </div>
                    <!-- header area end -->
                    <div class="main-content-inner">
                        <div class="row">
                            <!-- Progress Table start -->
                            <div class="col-12 mt-5" style="margin-bottom: 20px;">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="header-title">
                                            <button id="button-flat-mkdir"><img src="img/mkdir.png"> New</button>
                                            <button id="button-flat-mkfile"><img src="img/upload.png"> Upload</button>
                                            <a href="logout.php"><button id="button-flat-logout"><img src="img/logout.png" style="height : 16px"> Logout</button></a>
                                            <form id="mkdir" style="height:auto; width:50%; display:none; font-size : 12pt;" method="post" action="index.php">
                                                Name : <input type="text" style="width : 90%; padding : 0px 4px;" name="mkdir" placeholder="New Folder Name"><br>
                                                <button id="submit-btn" type="submit" style="margin-top : 10px;">Create</button>
                                            </form>
                                            <form id="mkfile" style="height:auto; width:50%; display:none; font-size : 12pt;" action="index.php" method="post" enctype="multipart/form-data">
                                                Upload file <input type="file" style="padding : 0px 4px;" name="upfile"><br>
                                                <button id="submit-btn" type="submit" style="margin-top : 10px;">Upload</button>
                                            </form>
                                            
                                        </div>
                                        <div class="single-table">
                                            <div class="table-responsive" style="height : auto; overflow: hidden;">
                                                <table class="table table-hover text-left" id="table" style="height : auto; overflow : hidden;">
                                                    <thead class="text-uppercase">
                                                        <tr class="text-center" style="background-color : cadetblue; color : white;">
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Size</th>
                                                            <th scope="col">Last Modified</th>
                                                            <th scope="col">type</th>
                                                            <th scope="col">action</th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    
                                                    $ls = ['dir'=>[], 'file'=>[]];
                                                    if(is_dir($dir)){
                                                        if($dh = opendir($dir)){
                                                            echo "<tbody>";
                                                            while(($file = readdir($dh)) !== false){
                                                                if(substr($file,0,1)!="." && substr($file,0,2)!=".."){
                                                                    $filePath = '/'.$file;
                                                                    if(($fileExt = pathinfo($filePath, PATHINFO_EXTENSION)) == ""){
                                                                        array_push($ls['dir'],$file);
                                                                    } else {
                                                                        array_push($ls['file'],$file);
                                                                    }
                                                                }
                                                            }
                                                            closedir($dh);
                                                        }
                                                        sort($ls['dir']);
                                                        sort($ls['file']);
                                                        $x = 1;
                                                        $path = isset($_GET['folder']) ? $_GET['folder']."/" : "";
                                                        foreach($ls['dir'] as $file){
                                                            $filePath = $file;
                                                            $statColor = "blue";
                                                            $fileExt = "dir";
                                                            $fileSize = "";
                                                            
                                                            ?>
                                                            <tr id = "<?php echo "ls-".$x;?>" name = "<?php echo "file-".$x; $x++;?>" value = "<?php echo $file;?>">
                                                                <th scope="row"><?php echo "<a href='index.php?folder=$filePath'>"; echo $file; echo '</a>';?></th>
                                                                <td class="text-center"><?php echo $fileSize; ?></td>
                                                                <td><?php echo date("F d, Y H:i:s", filemtime($filePath));?></td>
                                                                <td class="text-center"><span style="background-color:<?php echo $statColor;?>;" class="status-p"><?php echo $fileExt; ?></span></td>
                                                                <td class="d-flex justify-content-center"><?php echo "<a href='index.php?rmdir=$filePath'>"?><img src="img/trash-1.png" style="height:20px"></a></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        foreach($ls['file'] as $file){
                                                            $filePath = $path.$file;
                                                            $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
                                                            $statColor = 'green';
                                                            $fileSize = pretty_filesize($filePath);
                                                            ?>
                                                            <tr id = "<?php echo "ls-".$x;?>" name = "<?php echo "file-".$x; $x++;?>" value = "<?php echo $file;?>">
                                                                <th scope="row"><?php echo $file; ?></th>
                                                                <td class="text-center"><?php echo $fileSize; ?></td>
                                                                <td><?php echo date("F d, Y H:i:s", filemtime($filePath));?></td>
                                                                <td class="text-center"><span style="background-color:<?php echo $statColor;?>;" class="status-p"><?php echo $fileExt; ?></span></td>
                                                                <td class="d-flex justify-content-center"><?php echo "<a href='index.php?rmfile=$filePath'>"?><img src="img/trash-1.png" style="height:20px"></a><?php echo "   <a href='index.php?duplicate=$filePath'>"?><img src="img/duplicate.png" style="height:20px"></a></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    echo '</tbody>';
                                                    ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Progress Table end -->
                        </div>
                    </div>
                </div>
                <!-- main content area end -->
            </div>
            <!-- page container area end -->
            <!-- footer area start-->
            <div class="footer-area">
                <p>© Copyright 2018. All right reserved. Template by <a href="https://colorlib.com/wp/">Colorlib</a>.</p></p>
            </div>
            <!-- footer area end-->
            
            <!-- jquery latest version -->
            <script src="js/jquery-2.2.4.min.js" type="cd6086a0da2c33ebbcacb47a-text/javascript"></script>
            <script src="js/bootstrap.js" type="cd6086a0da2c33ebbcacb47a-text/javascript"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13" type="cd6086a0da2c33ebbcacb47a-text/javascript"></script>
        <script type="cd6086a0da2c33ebbcacb47a-text/javascript">

        $(document).ready(function(){
            $("#button-flat-mkdir").click(function(){
                $("form").fadeOut(1);
                $("#mkdir").fadeIn();
            });
            $("#button-flat-mkfile").click(function(){
                $("form").fadeOut(1);
                $("#mkfile").fadeIn();
            });
        });
        </script>
        <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/a2bd7673/cloudflare-static/rocket-loader.min.js" data-cf-settings="cd6086a0da2c33ebbcacb47a-|49" defer=""></script>
        </body>
    </html>
<?php 
} else {
    session_unset();
    session_destroy();
    header("Location: login.php");
}?>

        