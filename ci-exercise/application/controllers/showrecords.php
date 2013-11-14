<?php

/**
 * Controller responsible for rendering and passing campaign records to the View
 *
 * Class ShowRecords
 */
class ShowRecords extends CI_Controller
{
    protected $data = [];

    public function __construct()
    {
        parent::__construct();

        // load helpers and models for this route resource
        $this->load->model('Clients_model', '', true);
    }

    public function index()
    {
        $this->data['campaignRows'] = $this->Clients_model->generateCampaignTable();

        $this->load->view('campaignRecords', $this->data);
    }
} 