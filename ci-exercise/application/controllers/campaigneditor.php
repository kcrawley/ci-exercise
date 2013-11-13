<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campaigneditor extends CI_Controller {
    protected $formFields = [
        'client_names_id', 'brand_options_id', 'campaign_types_id', 'client_contacts_id',
        'campaign_name', 'notes'
    ];

    protected $data = [];

    public function __construct()
    {
        parent::__construct();

        // load helpers and models for this route resource
        $this->load->model('Clients_model', '', true);

        // loads data which will populate all views rendered from this controller
        $this->data['client_names'] = $this->Clients_model->getClientNames();
        $this->data['brand_options'] = $this->Clients_model->getBrandOptions();
        $this->data['campaign_types'] = $this->Clients_model->getCampaignTypes();

        // sets up dummy field
        $this->data['client_contacts'] = ['' => 'Please choose a client...'];

        // sets up empty value reference fields so we don't throw notices
        foreach($this->formFields as $formField) {
            $this->data[$formField] = '';
        }
    }

    public function index()
    {
        $this->load->view('campaignForm', $this->data);
    }

    public function load($id)
    {
        foreach ($this->Clients_model->loadClientResource($id) as $key => $resource) {
            $this->data[$key] = $resource;
        }

        $this->load->view('campaignForm', $this->data);
    }
}