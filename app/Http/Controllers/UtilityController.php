<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UtilityController extends Controller
{
    public function getColumnNameOfTable($table_name, $exclude_columns) {
        try {
            if ($exclude_columns) {
                $exclude_columns = json_encode($exclude_columns);
                $exclude_columns = str_replace("[", "", $exclude_columns);
                $exclude_columns = str_replace("]", "", $exclude_columns);
                $query = \DB::select("SELECT column_name FROM information_schema.columns WHERE table_name ='$table_name' AND COLUMN_NAME NOT IN($exclude_columns);");
            }
            else
                $query = \DB::select("SELECT column_name FROM information_schema.columns WHERE table_name ='$table_name';");
    
            if ($query) {
                $result = array_map(function ($value) {
                    return $value->column_name;
                }, $query);
                return $result;
            }
            else
                return [];
        } catch (\Exception $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            throw $e;
        }
    }
    public function getTotalColumnsOfTable($table_name, $exclude_columns) {
        try {
            if ($exclude_columns) {
                $exclude_columns = json_encode($exclude_columns);
                $exclude_columns = str_replace("[", "", $exclude_columns);
                $exclude_columns = str_replace("]", "", $exclude_columns);
                $query = \DB::select("SELECT count(*) AS total_columns FROM information_schema.columns WHERE table_name ='$table_name' AND COLUMN_NAME NOT IN($exclude_columns);");
            }
            else
                $query = \DB::select("SELECT count(*) AS total_columns FROM information_schema.columns WHERE table_name ='$table_name';");
    
            if ($query) {
                if (isset($query[0]->total_columns))
                    return $query[0]->total_columns;
                else
                    return 0;
            }
            else
                return 0;
        } catch (\Exception $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            throw $e;
        }
    }
}
