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
            <a class="navbar-brand" href="#">Campaign Manager</a>
        </div>
    </div>
</div>

<div class="jumbotron">
    <div class="container">
        <h1>Welcome!</h1>
        <p>CodeIgniter it is!</p>
        <p><a id="learnMore" class="btn btn-primary btn-lg" role="button">View Records &raquo;</a></p>
        <p><?= validation_errors(); ?></p>
        <p><?= $message ?></p>
    </div>
</div>

<div class="container">
    <?= form_open('/campaigneditor/create') ?>
    <div class="row">
        <div class="col-md-4">
            <h2>Client</h2>
            <div class="col-md-8">
                <?= form_dropdown('client_names_id', $client_names, set_value('client_names_id', $client_names_id), 'class="form-control"') ?>
            </div>
            <div class="col-md-4">
                <button id="client" type="button" class="addNewModal client-primary btn btn-primary">Add</button>
            </div>
        </div>
        <div class="col-md-4">
            <h2>Client Contact</h2>
            <div class="col-md-8">
                <?= form_dropdown('client_contacts_id', $client_contacts, set_value('client_contacts_id'), 'class="form-control"') ?>
            </div>
            <div class="col-md-4">
                <button id="contact" type="button" class="addNewModal client-primary btn btn-primary">Add</button>
            </div>
        </div>
        <div class="col-md-4">
            <h2>Brand</h2>
            <div class="col-md-8">
                <?= form_dropdown('brand_options_id', $brand_options, set_value('brand_options_id'), 'class="form-control"') ?>
            </div>
            <div class="col-md-4">
                <button id="brand" type="button" class="addNewModal client-primary btn btn-primary">Add</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h2>Campaign Types</h2>
            <div class="col-md-8">
                <?= form_multiselect('campaign_types_id[]', $campaign_types, $campaign_types_ids, 'class="form-control"') ?>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-horizontal" style="margin-top: 20px;">
                <div class="form-group">
                    <label for="inputCampaignName" class="col-sm-3 control-label">Campaign Name</label>
                    <div class="col-sm-9">
                        <?= form_input([
                            'name' => 'campaign_name',
                            'class' => 'form-control',
                            'id' => 'inputCampaignName',
                            'placeholder' => 'Campaign Name',
                            'value' => set_value('campaign_name')
                        ]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputCampaignNotes" class="col-sm-3 control-label">Campaign Notes</label>
                    <div class="col-sm-9">
                        <?= form_textarea([
                            'name'  => 'notes',
                            'class' => 'form-control',
                            'id'    => 'inputCampaignNotes',
                            'rows'  => 5,
                            'value' => set_value('notes')
                        ]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputStartDate" class="col-sm-3 control-label">Start Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="start_date" class="form-control" id="inputStartDate" value="<?= set_value('start_date') ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?= form_close(); ?>
    <hr>

    <footer>
        <p>&copy; Kevin Crawley 2013</p>
    </footer>
</div> <!-- /container -->

<div id="modal" class="modal fade"></div>
<div id="moreinfo" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hello! Thanks for checking this project out.</h4>
            </div>
            <div class="modal-body">
                <p class="lead">I used a good portion of logic from the initial campaign exercise here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/_library/js/jquery-2.0.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/_library/js/bootstrap.min.js"></script>
<script src="/_library/js/main.js"></script>
<script>campaign.initialize();</script>
</body>
</html>