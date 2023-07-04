<?php
// periksa_helper.php

if (!function_exists('store_periksa')) {
    function store_periksa($db)
    {
        $db->trans_start();

        try {
            // Get the data to be inserted into "periksa" table
            $periksa_data = array(
                'id_rm' => $_POST['id_rm'],
                'id_dokter' => $_POST['id_dokter'],
                'diagnosa' => $_POST['diagnosa'],
                'created_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "created_at" value
                'updated_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "updated_at" value
            );

            // Insert data into "periksa" table
            $db->insert('periksa', $periksa_data);
            $periksa_id = $db->insert_id();
            // Get the data to be inserted into "tindakan" table
            // Transform the array to the format required by insert_batch()
            $tindakanArray = $_POST['tindakan'];
            $data = array();
            if (!empty($tindakanArray)) {
                foreach ($tindakanArray as $key => $tindakan) {
                    $data[] = array(
                        'nama' => $_POST['tindakan'][$key],
                        'id_periksa' => $periksa_id,
                        'biaya' => $_POST['biaya_tindakan'][$key],
                        'created_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "created_at" value
                        'updated_at' => date('Y-m-d H:i:s'), // Set the current timestamp as the "updated_at" value
                    );
                }
            }

            // Insert the data into the database table
            if (!empty($data)) {
                $table = 'tindakan';
                $db->insert_batch($table, $data);
            }

            // delete antrean 
            $db->delete('antre', array('id' => $_POST['id_antre']));
            // Commit the transaction
            $db->trans_commit();

            // Optionally, you can redirect to another page after the transaction
            return true;
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $db->trans_rollback();

            // Handle the error (display error message, log, etc.)
            echo "Error: " . $e->getMessage();
            $this->session->set_flashdata('periksa', '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>');
            return false;
        }
    }

    function count_periksa_records_this_month($db)
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        $db->where("MONTH(created_at) =", $currentMonth);
        $db->where("YEAR(created_at) =", $currentYear);
        $db->from('periksa');
        return $db->count_all_results();
    }
}
