<?php

/**
 * Handles all things related to the database for this application as well as rendering custom
 * sections of some page views. This wasn't abstracted out to multiple Models, well, because this isn't
 * that big of an App.
 *
 * Class Clients_model
 */
class Clients_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets a list of brand names for use with the Form drop down
     *
     * @return array|bool
     */
    public function getBrandOptions()
    {
        $query = $this->db->get('brand_options');

        return $this->extractNames($query);
    }

    /**
     * Gets a list of client names for use with the Form drop down
     *
     * @return array|bool
     */
    public function getClientNames()
    {
        $query = $this->db->get('client_names');

        $initial[0] = 'Please choose a client...';

        return ($clientNames = $this->extractNames($query)) ? $initial + $clientNames : $initial;
    }

    /**
     * Gets a list of campaign types for use with the Form drop down
     *
     * @return array|bool
     */
    public function getCampaignTypes()
    {
        $query = $this->db->get('campaign_types');

        return $this->extractNames($query);
    }

    /**
     * Loads the specified resource and associations for use in the View
     *
     * @param $id
     * @return array
     */
    public function loadClientResource($id)
    {
        $query = $this->db->select('id as client_names_id')->get_where('client_names', ['id' => $id]);

        if ($query) {
            $results = $query->result_object();

            if (count($results)) {
                $results[0]->client_contacts = $this->getAssociatedContacts($id);

                return (array) $results[0];
            }
        }

        return [];
    }

    /**
     * Stores the main form record and creates associations
     *
     * @return bool
     */
    public function createCampaignRecord()
    {
        $this->db->insert('campaigns', [
            'client_contacts_id'    => $this->input->post('client_contacts_id'),
            'brand_options_id'      => $this->input->post('brand_options_id'),
            'client_names_id'       => $this->input->post('client_names_id'),
            'campaign_name'         => $this->input->post('campaign_name'),
            'start_date'            => date('Y-m-d 00:00:00', strtotime($this->input->post('start_date'))),
            'notes'                 => $this->input->post('notes')
        ]);

        $campaigns_id = $this->db->insert_id();

        if ($campaigns_id) {
            foreach($this->input->post('campaign_types_id') as $campaign_type) {
                $this->db->insert('campaigns_to_campaign_types', [
                    'campaigns_id'      => $campaigns_id,
                    'campaign_types_id' => $campaign_type
                ]);
            }

            return true;
        }

        return false;
    }

    /**
     * Determines what and where to save Name and any associated data
     *
     * @param array $input
     * @return bool
     */
    public function saveModalInput(Array $input)
    {
        // sets table values based on modal type
        switch ($input['modalType']) {
            case 'client':
                $table = 'client_names';
                break;
            case 'contact':
                $pivotTable = 'client_contacts_to_client_names';
                $table = 'client_contacts';
                break;
            case 'brand':
                $table = 'brand_options';
                break;
        }

        $query = $this->db->select_sum('id')->get_where($table, ['name' => $input['name']]);

        // determines if name already exists and inserts data into the db
        if ($query->row()->id > 0) {
            return false;
        } else {
            $this->db->insert($table, ['name' => $input['name']]);
            $parent_id = $this->db->insert_id();
        }

        // saves pivot data
        if (isset($pivotTable)) {
            $this->db->insert($pivotTable, [
                'client_contacts_id' => $parent_id,
                'client_names_id' => $input['modalClient']
            ]);
        }

        return $parent_id;
    }

    /**
     * Generates table rows for use with the records view
     *
     * @return string
     */
    public function generateCampaignTable()
    {
        $tableData = [];

        $query = $this->db->select('client_names.name as client_name, client_contacts.name as contact_name,
        campaigns.id, brand_options.name as brand_name, campaign_name, start_date, notes')->from('campaigns')->
        join('brand_options', 'brand_options.id = campaigns.brand_options_id')->
        join('client_names', 'client_names.id = campaigns.client_names_id')->
        join('client_contacts', 'client_contacts.id = campaigns.client_contacts_id')->get();

        if ($query) {
            $results = $query->result_object();

            if (count($results)) {
                foreach ($results as $row) {
                    $tableData[] = sprintf("
                    <tr>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s days</td>
                    </tr>",
                        $row->campaign_name,
                        $row->client_name,
                        $row->contact_name,
                        $this->getAssociatedTypesCount($row->id),
                        $row->brand_name,
                        $this->calculateStartDate($row->start_date)
                    );
                }
            }
        }

        return implode('', $tableData);
    }

    /**
     * Calculates the number of days between two dates
     *
     * @param string $date
     * @return int
     */
    protected function calculateStartDate($date)
    {
        $date_a = new DateTime("00:00:00");
        $date_b = new DateTime($date);

        $interval = $date_a->diff($date_b);
        $numeric = $interval->format('%a');

        if ($numeric > 0) {
            return $numeric;
        } else {
            return 0;
        }
    }

    /**
     * Fetches the number of Campaigns Types associated with a campaign record
     *
     * @param int $id
     * @return int
     */
    protected function getAssociatedTypesCount($id)
    {
        $query = $this->db->get_where('campaigns_to_campaign_types', ['campaigns_id' => $id]);

        return $query->num_rows();
    }

    /**
     * Returns the associated relations between client_names and client_contacts
     *
     * @param int $id
     * @return array
     */
    protected function getAssociatedContacts($id)
    {
        $clientContacts = [];
        $clientExists[0] = 'Please choose a contact...';
        $clientEmpty[0] = 'Please add a contact...';

        $query = $this->db->
            select('client_contacts.id, client_contacts.name')->where(['client_names_id' => $id])->
            join('client_contacts', 'client_contacts.id = client_contacts_to_client_names.client_contacts_id')->
            from('client_contacts_to_client_names')->get();

        if ($query) {
            $results = $query->result_object();

            foreach($results as $result) {
                $clientContacts[$result->id] = $result->name;
            }
        }

        return (count($clientContacts) > 0) ? $clientExists + $clientContacts : $clientEmpty;
    }

    /**
     * Simple method to extract id/name fields from database queries which are used to pass data to the view
     *
     * @param CI_Model $query
     * @return array|bool
     */
    protected function extractNames($query)
    {
        $nameRecords = [];

        // validates query so we don't start dropping notices
        if ($query) {
            $records = $query->result_object();

            // snoop-a-loop
            foreach($records as $record) {
                $nameRecords[$record->id] = $record->name;
            }
        }

        return ($nameRecords) ? $nameRecords : false;
    }
}