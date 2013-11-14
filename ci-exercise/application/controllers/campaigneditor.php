<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Contains resources used to display and process the form responsible for adding new campaign, client, contact,
 * and brand records.
 *
 * Class Campaigneditor
 */
class Campaigneditor extends CI_Controller {
    /**
     * View Data container
     *
     * @var array
     */
    protected $data = [];

    /**
     * Construct method sets up data used for this controllers views
     *
     */
    public function __construct()
    {
        parent::__construct();

        // load helpers and models for this route resource
        $this->load->model('Clients_model', '', true);

        // loads data which will populate all views rendered from this controller
        $this->data['client_names']         = $this->Clients_model->getClientNames();
        $this->data['brand_options']        = $this->Clients_model->getBrandOptions();
        $this->data['campaign_types']       = $this->Clients_model->getCampaignTypes();

        // sets up dummy fields
        $this->data['client_contacts']      = ['' => 'Please choose a client...'];
        $this->data['client_names_id']      = 0;
        $this->data['campaign_types_ids']   = '';

        // load session messages
        $this->data['message'] = $this->session->flashdata('message');
    }

    /**
     * Renders initial form
     */
    public function index()
    {
        $this->load->view('campaignForm', $this->data);
    }

    /**
     * Loads specific Client Name resource and associated data
     *
     * @param int $id
     */
    public function load($id)
    {
        foreach ($this->Clients_model->loadClientResource($id) as $key => $resource) {
            $this->data[$key] = $resource;
        }

        $this->load->view('campaignForm', $this->data);
    }

    /**
     * Processes, validates and creates new Campaign record
     */
    public function create()
    {
        $rules = [
            [
                'field'  => 'client_names_id',
                'label' => 'Client',
                'rules' => 'required|greater_than[0]'
            ],
            [
                'field'  => 'client_contacts_id',
                'label' => 'Client Contact',
                'rules' => 'required|greater_than[0]'
            ],
            [
                'field'  => 'brand_options_id',
                'label' => 'Brand Option',
                'rules' => 'required'
            ],
            [
                'field'  => 'campaign_types_id[]',
                'label' => 'Campaign Types',
                'rules' => 'required'
            ],
            [
                'field'  => 'campaign_name',
                'label' => 'Campaign Name',
                'rules' => 'required|callback_namefilter'
            ],
            [
                'field'  => 'notes',
                'label' => 'Notes',
                'rules' => ''
            ],
            [
                'field'  => 'start_date',
                'label' => 'Start Date',
                'rules' => 'required|callback_checkdate'
            ]
        ];

        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('greater_than', 'The %s field is required.');

        if ($this->form_validation->run() === false) {
            // set_value seems to barf when handling array values, so i did this instead
            $this->data['campaign_types_ids'] = $this->input->post('campaign_types_id');

            // loads the associated client_id so the form knows which Client name to render
            $clientResource = $this->Clients_model->loadClientResource($this->input->post('client_names_id'));

            // probably overly complicated, didn't realize only one value was needed here at first
            foreach ($clientResource as $key => $resource) {
                $this->data[$key] = $resource;
            }

            $this->load->view('campaignForm', $this->data);
        } else {
            if ($this->Clients_model->createCampaignRecord()) {
                $message = 'You\'ve added a new record! Huzzah!';
            } else {
                $message = 'Something went wrong...';
            };

            $this->session->set_flashdata('message', $message);

            redirect('/');
        }
    }

    /**
     * Custom filter used to validate the Campaign Name.
     *
     * @param string $str
     * @return bool
     */
    public function namefilter($str)
    {
        if (preg_match('/[a-zA-Z0-9_\-:!#]+$/', $str) === 0) {
            $this->form_validation->set_message(
                'namefilter', 'The %s field may only contain alphanumeric and/or _-:!#'
            );
            return false;
        } else {
            return true;
        }
    }

    /**
     * Custom filter used to determine if a submitted date is in the past.
     *
     * @param string $str
     * @return bool
     */
    public function checkdate($str)
    {
        if (strtotime($str) < strtotime('00:00:00')) {
            $this->form_validation->set_message(
                'checkdate', 'You do not own a Tardis. Please set %s to a date in the future.'
            );
            return false;
        } else {
            return true;
        }
    }
}