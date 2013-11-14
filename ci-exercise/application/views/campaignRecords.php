<!DOCTYPE html>
<html>
<head>
    <title>Campaign Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/_library/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Campaign Records</a>
        </div>
    </div>
</div>

<div class="container">
    <table style="margin-top: 70px;" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Campaign Name</th>
            <th>Client Name</th>
            <th>Client Contact</th>
            <th># Types</th>
            <th>Brand</th>
            <th>Starting in</th>
        </tr>
        </thead>
        <tbody>
        <?= $campaignRows ?>
        </tbody>

    </table>

    <footer>
        <p>&copy; Kevin Crawley 2013</p>
    </footer>
</div> <!-- /container -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/_library/js/jquery-2.0.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/_library/js/bootstrap.min.js"></script>
<script src="/_library/js/main.js"></script>
<script>campaign.initialize();</script>
</body>
</html>