<?php

namespace Controller;

use MeekroDB;  // Assuming you are using MeekroDB for database interactions

class Patients
{
    private $db;

    public function __construct()
    {
        $this->db = new MeekroDB();
    }

    // Function to get all patients
    public function get_patients()
    {
        try {
            $patients = $this->db->query("SELECT * FROM patients");
            echo json_encode(["patients" => $patients]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to fetch patients. Error: " . $e->getMessage()]);
        }
    }

    // Function to add a new patient
    public function add_patient()
    {
        try {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $date_of_birth = $_POST['date_of_birth'];

            $this->db->insert('patients', [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone_number' => $phone_number,
                'date_of_birth' => $date_of_birth,
                'date_of_registration' => date('Y-m-d H:i:s')
            ]);

            echo json_encode(["status" => 1, "message" => "Patient added successfully."]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to add patient. Error: " . $e->getMessage()]);
        }
    }

    public function get_patient($id)
{
    try {
        // Fetch the patient details by id
        $patient = $this->db->queryFirstRow("SELECT * FROM patients WHERE id = %i", $id);

        if ($patient) {
            echo json_encode($patient);  // Return the patient details as JSON
        } else {
            echo json_encode(["status" => 0, "message" => "Patient not found."]);
        }
    } catch (\Exception $e) {
        echo json_encode(["status" => 0, "message" => "Failed to retrieve patient. Error: " . $e->getMessage()]);
    }
}


    // Function to update an existing patient
    public function update_patient($id)
    {
        try {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $date_of_birth = $_POST['date_of_birth'];

            $this->db->update('patients', [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'phone_number' => $phone_number,
                'date_of_birth' => $date_of_birth
            ], "id=%i", $id);

            echo json_encode(["status" => 1, "message" => "Patient updated successfully."]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to update patient. Error: " . $e->getMessage()]);
        }
    }

    // Function to delete a patient
    public function delete_patient($id)
    {
        try {
            $this->db->query("DELETE FROM patients WHERE id = %i", $id);
            echo json_encode(["status" => 1, "message" => "Patient deleted successfully."]);
        } catch (\Exception $e) {
            echo json_encode(["status" => 0, "message" => "Failed to delete patient. Error: " . $e->getMessage()]);
        }
    }
}
?>
