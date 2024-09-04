<?php

namespace Controller;

class Notes
{
    private $db;

    function __construct()
    {
        $this->db = new \MeekroDB();
    }

    public function get_notes()
    {
        $notes = $this->db->query("
            SELECT notes.*, 
                   CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name 
            FROM notes 
            LEFT JOIN patients ON notes.patient_id = patients.id
        ");
        echo json_encode(["notes" => $notes]);
    }

    public function get_note($id)
    {
        $note = $this->db->queryFirstRow("
            SELECT notes.*, 
                   CONCAT(patients.first_name, ' ', patients.last_name) AS patient_name 
            FROM notes 
            LEFT JOIN patients ON notes.patient_id = patients.id 
            WHERE notes.id = %i", $id);
    
        echo json_encode($note);
    }

    public function add_note()
    {
        // Read input data from the request body as JSON
        $input = json_decode(file_get_contents('php://input'), true);

        // Validate input fields
        if (empty($input['patient_id']) || empty($input['note'])) {
            echo json_encode(["status" => 0, "message" => "All fields are required."]);
            return;
        }

        $this->db->insert('notes', [
            'patient_id' => (int) $input['patient_id'],
            'note' => $input['note']
        ]);
        echo json_encode(["status" => 1, "message" => "Note added successfully."]);
    }

    public function update_note($id)
    {
        // Read input data from the request body as JSON
        $input = json_decode(file_get_contents('php://input'), true);
    
        // Validate input fields
        if (empty($input['note'])) {
            echo json_encode(["status" => 0, "message" => "Note field is required."]);
            return;
        }
    
        // Your code to update the note in the database
        $this->db->update('notes', [
            'note' => $input['note'],
        ], "id=%i", $id);
    
        echo json_encode(["status" => 1, "message" => "Note updated successfully."]);
    }
    

    public function delete_note($id)
    {
        $this->db->delete('notes', "id=%i", $id);
        echo json_encode(["status" => 1, "message" => "Note deleted successfully."]);
    }
}
?>
