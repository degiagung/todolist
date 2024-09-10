<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class Master
{
    const INFO_SUCCESS = 'Success';
    const INFO_FAILED = 'Failed';
    const CODE_SUCCESS = '00';
    const CODE_FAILED = '01';
    const BEARER = '$dgfdgkjfgkjfgkjfkj'; 
    public function Results($data, $asJson = false)
    {
        $defaultData = [
            'guid' => 0,
            'code' => self::CODE_SUCCESS,
            'info' => self::INFO_SUCCESS,
            'data' => null,
        ];
        

        if ($data !== null) {
            $data = Master::checkArray($data);
            $setArr = array_merge($defaultData, $data);
        } else {
            $setArr = $defaultData;
        }

        if ($asJson) {
            return response()->json($setArr);
        } else {
            return $setArr; // Jika Anda ingin mengembalikan dalam bentuk array
        }
    }


    protected function checkArray($isData)
    {
        
        if (!isset($isData['guid'])) {
            $isData['guid'] = 0;
        }
        if (!isset($isData['info'])) {
            $isData['info'] = self::INFO_SUCCESS;
        }
        if (!isset($isData['code'])) {
            $isData['code'] = self::CODE_SUCCESS;
        }
        if (!isset($isData['data'])) {
            $isData['data'] = null;
        }
        return $isData;
    }

    public function selectGlobal($kolom = '',$table,$where = null){
        $query = "
            SELECT
                $kolom
            FROM
                $table
        ";
        if($where != null){
            $query .= "
                WHERE $where
            ";
        }

        // dd($query);die;
        $select = DB::select($query);
        $select = $this->checkErrorModel($select);

        if ($select['code'] == '0') {
            $results = [
                'code' => self::CODE_SUCCESS,
                'info' => self::INFO_SUCCESS,
                'data' => $select['data'] // balikin id
            ];
        } else {
            $results = [
                'code' => self::FAILED,
                'info' => self::INFO_FAILED,
                'data' => null
            ];
        }

        return $results;
    }

    public function saveGlobal($table,$atribut){
        foreach ($atribut as $key => $value) {
            // if ((strpos($value, '<') !== false) or (strpos($value, '>') !== false))
            if (preg_match('/[\`><>]/', $value))
            {
                $result->code = 1;
                return $result;
            }
        }
        
        $saved = DB::table($table)->insertGetId(
            $atribut
        );
        
        if ($saved != null) {
            $results = [
                'code' => self::CODE_SUCCESS,
                'info' => self::INFO_SUCCESS,
                'data' => $saved // balikin id
            ];
        } else {
            $results = [
                'code' => self::FAILED,
                'info' => self::INFO_FAILED,
                'data' => null
            ];
        }

        return $results;
    }

    public function updateGlobal($table,$atribut,$where){
        foreach ($atribut as $key => $value) {
            // if ((strpos($value, '<') !== false) or (strpos($value, '>') !== false))
            if (preg_match('/[\`><>]/', $value))
            {
                $result->code = 1;
                return $result;
            }
        }
        
        $saved = DB::table($table)
        ->where($where)
        ->update($atribut);

        // dd($saved);
        if ($saved) {
            $results = [
                'code' => self::CODE_SUCCESS,
                'info' => self::INFO_SUCCESS,
            ];
        } else {
            $results = [
                'code' => self::CODE_FAILED,
                'info' => self::INFO_FAILED,
            ];
        }

        return $results;
    }

    public function getIncrement($table){
        
        $id=DB::select("SHOW TABLE STATUS LIKE '$table'");
        $next_id=$id[0]->Auto_increment;
        if ($next_id) {
            $results = [
                'code' => self::CODE_SUCCESS,
                'info' => self::INFO_SUCCESS,
                'data' => $next_id // balikin id
            ];
        } else {
            $results = [
                'code' => self::CODE_FAILED,
                'info' => self::INFO_FAILED,
            ];
        }

        return $results;
    }

    public function deleteGlobal($table,$where){
        foreach ($where as $key => $value) {
            // if ((strpos($value, '<') !== false) or (strpos($value, '>') !== false))
            if (preg_match('/[\`><>]/', $value))
            {
                $result->code = 1;
                return $result;
            }
        }
        
        $query = DB::table($table);
        foreach($where as $field => $value) {
            $query->where($field, $value);
        }
        $deleted = $query->delete();
        if ($deleted) {
            $results = [
                'code' => self::CODE_SUCCESS,
                'info' => self::INFO_SUCCESS,
            ];
        } else {
            $results = [
                'code' => self::CODE_FAILED,
                'info' => self::INFO_FAILED,
            ];
        }

        return $results;
    }
    
}

