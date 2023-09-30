<?php

/**
 * contoh penggunaan
 *   return DataTableFormat::Call($request)->query(function () {
 *          query pada tahap ini tidak mengeluarkan result
            return Operator::query();
        })
            ->filter(function ($query) {
                ini merupakan filter jika ada jika tidak boleh di hapus saja
                $query->where("jenis_kelamin", "Laki-laki");
            })
            --order bay
            ->Short("id")
            -- membuat format result
            ->formatRecords(function ($result, $start) {
                $data_arr = [];
                $sno = $start + 1;
                foreach ($result as $record) {
                    $data_arr[] = [
                        'No' => $sno,
                        'nama' => $record->nama,
                        'jenis_kelamin' => $record->jenis_kelamin,
                    ];
                    $sno++;
                }
                return $data_arr;
            })
            ->get()->json();
 */

namespace  App\Service;

use Illuminate\Http\Request;

class DataTableFormat
{
    public $draw;
    public $start;
    public $rowperpage;
    public $columnIndex_arr;
    public $columnName_arr;
    public $order_arr;
    public $search_arr;
    public $columnIndex;
    public $columnName;
    public $columnSortOrder;
    public $searchValue;
    public $totalRecordswithFilter = null;
    public $results;
    public $fRec = null;



    public function __construct($request)
    {
        $this->draw = $request->get('draw');
        $this->start = $request->get("start");
        $this->rowperpage = $request->get("length"); // Rows display per page
        $this->columnIndex_arr = $request->get('order');
        $this->columnName_arr = $request->get('columns');
        $this->order_arr = $request->get('order');
        $this->search_arr = $request->get('search');
        $this->columnIndex = $this->columnIndex_arr[0]['column']; // Column index
        $this->columnName = $this->columnName_arr[$this->columnIndex]['data']; // Column name
        $this->columnSortOrder = $this->order_arr[0]['dir']; // asc or desc
        $this->searchValue = $this->search_arr['value']; // Search value
    }
    public static function Call($request = null)
    {
        if (empty($request))
            $request = request();
        return new DataTableFormat($request);
    }

    public function query($QueryFunction)
    {
        $this->results = $QueryFunction();
        return $this;
    }
    public function Short($short)
    {
        $this->results =  $this->results->orderBy($short, $this->columnSortOrder);
        return $this;
    }
    public function paginet()
    {
        return $this->results->skip($this->start)->take($this->rowperpage)->get();
    }

    public function formatRecords($callback)
    {
        $this->fRec =  $callback($this->paginet(), $this->start);
        return $this;
    }

    public function filter($QueryFilter)
    {
        $this->totalRecordswithFilter = $this->results->where($QueryFilter)->count();
        return $this;
    }
    public function inFilter()
    {
        return  $this->results->count();
    }

    public function totalRecords()
    {
        return $this->results->count();
    }

    public function get()
    {
        if (empty($this->fRec))
            $this->fRec = $this->paginet();
        return  ResponseApi::datatableFormat()
            ->draw($this->draw)
            ->iTotalRecords($this->totalRecords())
            ->iTotalDisplayRecords($this->totalRecordswithFilter != null ?: $this->inFilter())
            ->aaData($this->fRec);
    }
}
