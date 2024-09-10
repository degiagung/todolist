<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Helpers\Master;

class ApiController extends Controller
{
    public function checklist(Request $request){
        
        $token = $request->bearerToken();
        $MasterClass    = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){
    
    
            $data = DB::select("
                SELECT 
                    ch.*
                FROM 
                    checklists ch");
            // $data = DB::select("
            //     SELECT 
            //         ch.id as id_checklist,ch.checklist_name,ch.checklist,ch.status checklist_status,ci.id as id_checklistitem,ci.*
            //     FROM 
            //         checklists ch 
            //         LEFT JOIN checklistitems ci ON ch.id = ci.id_checklist");
    
            $result = [
                'code' => $MasterClass::CODE_SUCCESS ,
                'info' => $MasterClass::INFO_SUCCESS ,
                'data' => $data
            ];
        }else{
            
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];
        }

        return $result ;
        // print_r($data);die;
    }
    public function createchecklist(Request $request){
        
        DB::beginTransaction();     
        $token          = $request->bearerToken();
        $MasterClass    = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){
            $content            = $request->input() ;
            $name               = $request->input()['name'] ;
            $attr      = [
                'checklist_name'    => $name,
            ];
            $save               = $MasterClass->saveGlobal('checklists', $attr );
            if($save['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }

        }else{
            
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];
        }

        return $result ;
    }
    public function deletechecklist($id){
        DB::beginTransaction();  
        $MasterClass = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){   
            $where     = [
                'id' => $id
            ];
            $delete      = $MasterClass->deleteGlobal('checklists', $where );

            if($delete['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }
        }else{
    
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];

        }
    

        return $result ;

    }
    public function checklistitem($id,Request $request){
        $token = $request->bearerToken();
        $MasterClass    = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){
    
    
            $data = DB::select("
                SELECT 
                    ch.id as checklistid,ch.checklist_name,ch.checklist,ch.status checklist_status,ci.id as ichecklistitemid,ci.*
                FROM 
                    checklists ch 
                    LEFT JOIN checklistitems ci ON ch.id = ci.id_checklist
                WHERE
                    ch.id = $id");
    
            $result = [
                'code' => $MasterClass::CODE_SUCCESS ,
                'info' => $MasterClass::INFO_SUCCESS ,
                'data' => $data
            ];
        }else{
            
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];
        }

        return $result ;
        // print_r($data);die;
    }
    public function createchecklistitem($id,Request $request){
        
        DB::beginTransaction(); 
        $token          = $request->bearerToken();
        $MasterClass    = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){
            $content            = $request->input() ;
            $name               = $request->input()['name'] ;
            $attr      = [
                'checklistitem_name'    => $name,
                'id_checklist'          => $id,
            ];
            $save               = $MasterClass->saveGlobal('checklistitems', $attr );
            if($save['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }

        }else{
            
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];
        }

        return $result ;
    }
    public function checklistitembychekid($id,Request $request,$iditem){
        $token = $request->bearerToken();
        $MasterClass    = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){
    
    
            $data = DB::select("
                SELECT 
                    ch.id as checklistid,ch.checklist_name,ch.checklist,ch.status checklist_status,ci.id as ichecklistitemid,ci.*
                FROM 
                    checklists ch 
                    JOIN checklistitems ci ON ch.id = ci.id_checklist
                WHERE 
                    ch.id = $id AND ci.id = $iditem   ");
    
            $result = [
                'code' => $MasterClass::CODE_SUCCESS ,
                'info' => $MasterClass::INFO_SUCCESS ,
                'data' => $data
            ];
        }else{
            
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];
        }

        return $result ;
        // print_r($data);die;
    }
    public function updatechecklistitem($id,Request $request,$iditem){
        DB::beginTransaction();  
        $MasterClass = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){   
            $attr     = [
                'status'        => 'check',
            ];
            $where     = [
                'id'            => $iditem,
                'id_checklist'  => $id,
            ];
            $udpate      = $MasterClass->updateGlobal('checklistitems',$attr, $where );

            if($udpate['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }
        }else{
    
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];

        }
    

        return $result ;

    }
    public function deletechecklistitem($id,Request $request,$iditem){
        DB::beginTransaction();  
        $MasterClass = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){   
            $where     = [
                'id'            => $iditem,
                'id_checklist'  => $id
            ];
            $delete      = $MasterClass->deleteGlobal('checklistitems', $where );

            if($delete['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }
        }else{
    
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];

        }
    

        return $result ;

    }
    public function renamechecklistitem($id,Request $request,$iditem){
        DB::beginTransaction();  
        $MasterClass = new Master();
        if($MasterClass::BEARER === '$dgfdgkjfgkjfgkjfkj'){   
            $content            = $request->input() ;
            $name               = $request->input()['name'] ;
            $attr     = [
                'checklistitem_name'        => $name,
            ];
            $where     = [
                'id'            => $iditem,
                'id_checklist'  => $id,
            ];
            $udpate      = $MasterClass->updateGlobal('checklistitems',$attr, $where );

            if($udpate['code']    == $MasterClass::CODE_SUCCESS){
                DB::commit();
                $result    = [
                    'code'  => $MasterClass::CODE_SUCCESS,
                    'info'  => $MasterClass::INFO_SUCCESS,
                ];
            }else{
                DB::rollBack();
                $result = [
                    'code' => $MasterClass::CODE_FAILED ,
                    'info' => $MasterClass::INFO_FAILED ,
                ];

            }
        }else{
    
            $result = [
                'code' => $MasterClass::CODE_FAILED ,
                'info' => $MasterClass::INFO_FAILED ,
            ];

        }
    

        return $result ;

    }
}
