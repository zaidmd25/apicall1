<html> 
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel Uploading</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style>
.container { 
margin-top:2%;
}
</style> 
</head> 
<body>
@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error) 
        <li>{{ $error }}</li> 
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('message'))
    <div class="alert alert-success">
        {{ Session::get('message') }}
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8"><h2>Laravel File Upload</h2>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form action="multiuploads" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
                <label for="Product Name">Upload files of format(jpeg,bmp,png):</label>
            <br />
                <input type="file" class="form-control" name="filename" multiple />
            <br /><br />
                <input type="submit" class="btn btn-primary" value="Upload" />
            </form>
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
$(".btn-submit").click(function(e){
    // e.preventDefault();
    $.ajax({
        type:'POST',
        url:'/multiuploads',
        data: ,
        success:function(data){
         alert(data.success);
        }
    });
});
</script> -->
</body>
</html>