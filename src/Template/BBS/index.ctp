<nav class="navbar navbar-inverse">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="test">こたに掲示板</a>
        </div>
    </div>
</nav>

<div class="col-md-3" >
    <?php
    echo $this->Form->create();
    echo $this->Form->input('名前');
    echo $this->Form->textarea('contents');
    echo $this->Form->file('image');
    echo $this->Form->button('投稿', [
        'class' => 'btn btn-primary'
    ]);
    echo $this->form->end();
    ?>
</div>

<div class="col-md-9">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>投稿内容</th>
                    <th>投稿時間</th>
                    <th>削除</th>
                </tr>
                <tbody>
                    <?php
                    $connect = mysql_connect("localhost","root","");

                    //SQLをUTF8形式で書くよ、という意味
                    mysql_query( "SET NAMES utf8",$connect );

                    if(isset($_POST['write'])){
                        $account  = $_POST["account"];
                        $contents = $_POST["contents"];
                        $tname = $_FILES['image']['tmp_name'];
                        $len = mb_strlen($contents,"utf-8");

                        if($len == 0){
                            echo "空白です";
                        }else if($len > 140){
                            echo "文字数オーバーです";
                        }else{
                            //testというデータベースに対してSQLを実行する
                            mysql_db_query( "test", "INSERT tweet_tbl(account,contents,input_datetime)
                            values('$account','$contents',sysdate())" );
                        }
                        if( $tname ){
                            $type = $_FILES['image']['type'];
                            if ($type != "image/jpeg" && $type != "image/pjpeg") {
                                //error("JPEG形式ではありません");
                            }
                            $no = mysql_insert_id();
                            $path = "image/$no.jpg";
                            move_uploaded_file($tname, $path);
                            $path_t = "image/{$no}_t.jpg";
                            list($sw, $sh) = getimagesize($path);
                            $dw = 128;
                            $dh = $dw * $sh / $sw;
                            $src = imagecreatefromjpeg($path);
                            $dst = imagecreatetruecolor($dw, $dh);
                            imagecopyresized($dst, $src, 0, 0, 0, 0, $dw, $dh, $sw, $sh);
                            imagejpeg($dst, $path_t);
                        }

                    }
                    if(isset($_POST['delete'])){
                        $tweet_id = $_POST['tweet_id'];
                        mysql_db_query("test","delete from tweet_tbl where tweet_id = $tweet_id");
                    }

                    //登録された時間の新しい時間に並べて表示したい
                    //この１行で実行
                    $rs = mysql_db_query("test","select * from tweet_tbl order by input_datetime desc");

                    while($row = mysql_fetch_assoc($rs)){
                        $tweet_id = $row["tweet_id"];
                        echo "<tr>";
                        //echo "<td>{$row['tweet_id']}</td>";
                        echo "<td>{$row['account']}</td>";
                        echo "<td>{$row['contents']}";
                        $fn = "image/{$tweet_id}.jpg";
                        $fn_t = "image/{$tweet_id}_t.jpg";
                        if (file_exists($fn)) {
                            print "<br><a href='$fn'><img src='$fn_t' border='0'></a>";
                        }
                        echo "</td>";
                        echo "<td>{$row['input_datetime']}</td>";
                        echo "<td><form method=\"post\" action=\"bbs.php\">";
                        echo "<input type=\"hidden\" name=\"tweet_id\" value={$row['tweet_id']}>";
                        echo "<input type=\"submit\" name=\"delete\" value=\"削除\" class=\"btn btn-danger\">";
                        echo "</form></td>";
                        echo "</tr>";
                    }

                    //データベースとの接続を切る
                    mysql_close($connect);

                    ?>
                </tbody>
            </thead>
        </table>
    </div>
</div>
