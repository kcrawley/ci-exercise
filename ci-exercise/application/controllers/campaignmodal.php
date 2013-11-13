<?php

class Campaignmodal extends CI_Controller
{
    protected $formFields = [
        'name', 'modalType', 'modalTitle', 'modalClient', 'formError'
    ];

    protected $data = [];

    public function __construct()
    {
        parent::__construct();

        // load helpers and models for this route resource
        $this->load->model('Clients_model', '', true);

        // sets up empty value reference fields so we don't throw notices
        foreach($this->formFields as $formField) {
            $this->data[$formField] = '';
        }
    }

    public function index()
    {
        $this->data['modalClient'] = $this->input->get('modalClient');
        $this->data['modalType'] = $this->input->get('modalType');
        $this->data['modalTitle'] = $this->input->get('modalTitle');

        $this->load->view('campaignModal', $this->data);
    }

    public function save()
    {
        $errors = false;
        $this->data['modalTitle'] = $this->input->post('modalTitle');

        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
            ],
            [
                'field' => 'modalTitle',
                'label' => '',
                'rules' => ''
            ],
            [
                'field' => 'modalType',
                'label' => '',
                'rules' => ''
            ],
            [
                'field' => 'modalClient',
                'label' => '',
                'rules' => ''
            ]
        ];

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() === false) {
            $errors = true;
            $this->data['formError'] = validation_errors();
        } else {
            $results = $this->Clients_model->saveModalInput($this->input->post());

            if (is_numeric($results)) {
                $jsonData = ['status' => true, 'id' => $results];
            } else {
                $errors = true;
                $this->data['formError'] = 'Duplicate entry detected. Please try again.';
            }
        }

        if ($errors) {
            $view = $this->load->view('campaignModal', $this->data, true);

            $jsonData = ['status' => false, 'html' => $view];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($jsonData));
    }
}