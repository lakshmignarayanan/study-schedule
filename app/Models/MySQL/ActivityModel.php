<?php

namespace App\Models\MySQL;

class ActivityModel {

    //lets assume this is the source of data
    public function get() {
        $json = file_get_contents(Config("schedule.sample_data"));
        return json_decode($json, true);
    }

}