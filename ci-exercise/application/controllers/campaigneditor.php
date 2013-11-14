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

        // sets up dummy fields
        $this->data['client_contacts'] = ['' => 'Please choose a client...'];
        $this->data['client_names_id'] = 0;
        $this->data['campaign_types_ids'] = '';

        // load session messages
        $this->data['message'] = $this->session->flashdata('message');
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

    public function create()
    {
        $rules = array(
            array(
                'field'  => 'client_names_id',
                'label' => 'Client Name',
                'rules' => 'required|greater_than[0]'
            ),
            array(
                'field'  => 'client_contacts_id',
                'label' => 'Client Contact',
                'rules' => 'required|greater_than[0]'
            ),
            array(
                'field'  => 'brand_options_id',
                'label' => 'Brand Option',
                'rules' => 'required'
            ),
            array(
                'field'  => 'campaign_types_id[]',
                'label' => 'Campaign Type',
                'rules' => 'required'
            ),
            array(
                'field'  => 'campaign_name',
                'label' => 'Campaign Name',
                'rules' => 'required|callback_namefilter'
            ),
            array(
                'field'  => 'notes',
                'label' => 'Notes',
                'rules' => ''
            ),
            array(
                'field'  => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required|callback_checkdate'
            )
        );

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === false) {
            // set_value seems to barf when handling array values, so i did this instead
            $this->data['campaign_types_ids'] = $this->input->post('campaign_types_id');

            foreach ($this->Clients_model->loadClientResource($this->input->post('client_names_id')) as $key => $resource) {
                $this->data[$key] = $resource;
            }

            $this->load->view('campaignForm', $this->data);
        } else {
            if ($this->Clients_model->createCampaignRecord($this->input->post())) {
                $message = 'You\'ve added a new record! Huzzah!';
            } else {
                $message = 'Something went wrong...';
            };

            $this->session->set_flashdata('message', $message);

            redirect('/');
        }
    }

    public function namefilter($str)
    {
        if (preg_match('/[a-zA-Z0-9_\-:!#]+$/', $str) === 0) {
            $this->form_validation->set_message('namefilter', 'The %s field may only contain alphanumeric and/or _-:!#');
            return false;
        } else {
            return true;
        }
    }

    public function checkdate($str)
    {
        if (strtotime($str) < strtotime('00:00:00')) {
            $this->form_validation->set_message('checkdate', 'You do not own a Tardis. Please set %s to a date in the future.');
            return false;
        } else {
            return true;
        }
    }
}