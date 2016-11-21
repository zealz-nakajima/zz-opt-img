<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>タイトル</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="//code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="col-md-10 col-sm-12">
        <div class="page-header">
            <h1 id="container">Compress Image</h1>
        </div>

        <script>
            $(function () {
                if (window.File && window.FileReader && window.FileList && window.Blob) {
                    // アップロードするファイルを選択
                    $('input[type=file]').change(function () {
                        // 1. 選択されたファイルがない場合は何もせずにreturn
                        if (!this.files.length) {
                            return;
                        }
                        var fd = $(this).parent('form').get()[0];
                        var formdata = new FormData(fd);
                        $.ajax({
                            type: 'POST',
                            url: "/compress-image.php",
                            cache: false,
                            dataType: 'html',
                            data: formdata,
                            processData: false,
                            contentType: false,
                            success: function (data, textStatus, jqXHR) {
                                $("#results").append(data);
                            }
                        });
                    });

                } else {
                    alert('The File APIs are not fully supported in this browser.');
                }

            });
        </script>
        jpgとPNGのみ。
        <form id="form1" method="post" action="./compress-image.php" enctype="multipart/form-data">
            <input type="file" name="f"/>
            <input type="submit">
        </form>
        <div id="results"></div>
    </div>
</div>
</body>
</html>


<script>
    $(document).ready(function () {
        var $form, fd;
        $("#form1").submit(function () {
            console.log("a");
            $form = $(this);
            console.log($form[0]);
            fd = new FormData($form[0]);
            console.log(fd);
            $.ajax($form.attr("action"), {
                type: "POST",
                data: fd,
                success: function (msg) {
                    alert("Data Saved: " + msg);
                }
            });
            return false;
        });
    });
</script>
