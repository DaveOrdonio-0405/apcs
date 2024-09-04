<?php
namespace Controller; // Ensure the namespace is correct

class Vaccination
{
    private $db;

    function __construct()
    {
        $this->db = new \MeekroDB();
    }

    public function get_vaccinations()
    {
        $vaccinations = $this->db->query("
            SELECT vaccinations.*, 
                   CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name 
            FROM vaccinations 
            LEFT JOIN patients ON vaccinations.patient_id = patients.id
        ");
        echo json_encode(["vaccinations" => $vaccinations]);
    }

    public function get_vaccination($id)
    {
        $vaccination = $this->db->queryFirstRow("
            SELECT vaccinations.*, 
                   CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name 
            FROM vaccinations 
            LEFT JOIN patients ON vaccinations.patient_id = patients.id 
            WHERE vaccinations.id = %i", $id);
    
        echo json_encode($vaccination);
    }

    public function add_vaccination()
    {
        // Read input data from the request body as JSON
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Validate input fields
        if (empty($input['patient_id']) || empty($input['vaccine_type']) || empty($input['date_of_vaccination'])) {
            echo json_encode(["status" => 0, "message" => "All fields are required."]);
            return;
        }
    
        $this->db->insert('vaccinations', [
            'patient_id' => (int) $input['patient_id'],
            'vaccine_type' => $input['vaccine_type'],
            'date_of_vaccination' => $input['date_of_vaccination'],
            'next_due_date' => $input['next_due_date'],
        ]);
        echo json_encode(["status" => 1, "message" => "Vaccination record added successfully."]);
    }

    public function update_vaccination($id)
    {
        // Read input data from the request body as JSON
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Validate input fields
        if (empty($input['patient_id']) || empty($input['vaccine_type']) || empty($input['date_of_vaccination'])) {
            echo json_encode(["status" => 0, "message" => "All fields are required."]);
            return;
        }
    
        $this->db->update('vaccinations', [
            'patient_id' => (int) $input['patient_id'],
            'vaccine_type' => $input['vaccine_type'],
            'date_of_vaccination' => $input['date_of_vaccination'],
            'next_due_date' => $input['next_due_date'],
        ], "id=%i", $id);
        echo json_encode(["status" => 1, "message" => "Vaccination record updated successfully."]);
    }

    public function delete_vaccination($id)
    {
        $this->db->delete('vaccinations', "id=%i", $id);
        echo json_encode(["status" => 1, "message" => "Vaccination record deleted successfully."]);
    }
}
?>
