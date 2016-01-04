<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_csv extends CI_Model {

    public function array_put_csv($filename, $assocDataArray) {
        $this->load->helper('csv');
//        ob_clean();
//        header('Pragma: public');
//        header('Expires: 0');
//        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//        header('Cache-Control: private', false);
//        header('Content-Type: application/csv');
//        header('Content-Disposition: attachment;filename=' . $fileName);
//        $fp = fopen('php://output', 'w');
//        foreach ($assocDataArray AS $values) {
//            fputcsv($fp, $values);
//        }
//        fclose($fp);
//        ob_flush();
        
        
        header("Content-Type: text/csv;charset=utf-8");
        header("Content-Disposition: attachment;filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        $fp = fopen('php://output', 'w');

        foreach ($assocDataArray as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
        exit();
    }

}

/* End of file model_csv.php */
/* Location ./application/models/model_csv.php */