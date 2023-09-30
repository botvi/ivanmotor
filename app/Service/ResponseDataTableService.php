<?php

namespace App\Service;

use Illuminate\Http\Request;

trait ResponseDataTableService
{
    public function draw($draw)
    {
        $this->data['draw'] = $draw;
        return $this;
    }
    public function iTotalRecords($iTotalRecords)
    {
        $this->data['iTotalRecords'] = $iTotalRecords;
        return $this;
    }
    public function iTotalDisplayRecords($iTotalDisplayRecords)
    {
        $this->data['iTotalDisplayRecords'] = $iTotalDisplayRecords;
        return $this;
    }
    public function aaData($aaData)
    {
        $this->data['aaData'] = $aaData;
        return $this;
    }
}
