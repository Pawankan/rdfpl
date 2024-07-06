<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SqlQuery_model extends CI_Model
{
    public function sql_select_where($tablename,$where)
    {
        $this->db->select('*');
        $query=$this->db->get_where($tablename,$where); 
        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }
    }


  public function sql_select_where_desc($tablename,$col_name,$where)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'DESC');
        $query=$this->db->get_where($tablename,$where); 

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }


     public function sql_select_where_asc($tablename,$col_name,$where)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'ASC');
        $query=$this->db->get_where($tablename,$where); 

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }

      public function sql_query_update($sqry)
    {
        $query=$this->db->query($sqry);
        if($query) 
        {
           return $query;
        }
        else
        {
           return 0;
        }
    }
  public function sql_select_limit_where($tablename,$col_name,$num,$where)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'DESC');
        $this->db->limit($num);
        // $query=$this->db->get($tablename); 
        $query=$this->db->get_where($tablename,$where);

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }

public function sql_queryUpdate($sqry)
    {
        $query=$this->db->query($sqry);
        if($query){
           return $query;
        }
        else
        {
           return 0;
        }

    }


     public function sql_select_limit_where_asc($tablename,$col_name,$num,$where)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'ASC');
        $this->db->limit($num);
        // $query=$this->db->get($tablename); 
        $query=$this->db->get_where($tablename,$where);

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }


    public function sql_select_limit_where_desc($tablename,$col_name,$num,$where)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'DESC');
        $this->db->limit($num);
        // $query=$this->db->get($tablename); 
        $query=$this->db->get_where($tablename,$where);

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }



    public function sql_select($tablename,$col_name)
    {
        $this->db->select('*');
        $this->db->order_by($col_name,'DESC');
        $query=$this->db->get($tablename); 

        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }



    public function sql_insert($tablename,$data)
    {
        $query=$this->db->insert($tablename,$data);
        if($query)
        {
           return 1;  
        }
        else
        {
           return 0;  
        }
    }

    public function sql_update($tablename,$data,$where)
    {
        $query=$this->db->update($tablename,$data,$where);
        if($query)
        {
           return 1;  
        }
        else
        {
           return 0;  
        }
    }




public function get_current_page_records($tablename,$limit, $start,$where) 
    {
        $this->db->limit($limit, $start);
        // $query = $this->db->get($tablename,$where);
        $query=$this->db->get_where($tablename,$where);
 
        if ($query->num_rows() > 0) 
        {
            foreach ($query->result() as $row) 
            {
                $data[] = $row;
            }
             
            return $data;
        }
 
        return 0;
    }
     
    public function get_total($tablename,$where) 
    {
          $query=$this->db->get_where($tablename,$where);
        return $query->num_rows();
        // return $this->db->count_all($tablename);
    }

 // public function sql_update_or($tablename,$data,$email,$contact)
 //    {
 //        $query=$this->db->update($tablename,$data);
 //        $this->db->where('contact=', $contact);
 //        $this->db->or_where('email=', $email);
 //         // $retu=$this->db->affected_rows();
 //        if($query)
 //        {
 //           return 1;  
 //        }
 //        else
 //        {
 //           return 0;  
 //        }
 //    }



    


    public function sql_delete($tablename,$where)
    {
         $query=$this->db->delete($tablename,$where);
        if($query)
        {
           return 1;  
        }
        else
        {
           return 0;  
        }
    }

     public function sql_query_delete($sqry)
    {
        $query=$this->db->query($sqry);
        
        if($query) 
        {
           return $query;
        }
        else
        {
           return 0;
        }

    }
   
 public function sql_query($sqry)
    {
        $query=$this->db->query($sqry);
        $result=$query->result();
        if($result) 
        {
           return $result;
        }
        else
        {
           return 0;
        }

    }

    public function sql_insert_batch($tablename,$data)
    {

       $query=$this->db->insert_batch($tablename,$data);
        if($query)
        {
           return 1;  
        }
        else
        {
           return 0;  
        }
    }


  // public function get_current_page_records($limit, $start) 
  //   {
  //       $this->db->limit($limit, $start);
  //      // $this->db->get();
  //       $query =$this->db->get_where("tbl_blogs",array('status'=>1)); 
  //       if ($query->num_rows() > 0) 
  //       {
  //           foreach ($query->result() as $row) 
  //           {
  //               $data[] = $row;
  //           }
             
  //           return $data;
  //       }else{
  //          return 0;  
  //       }
 
        
  //   }
     
    // public function get_total() 
    // {
    //     return $this->db->count_all("tbl_blogs");
    // }


     public function get_last_inset_id($tablename)
    {
        $return=$this->db->insert_id($tablename);
        return $return;
    }



   public function get_TableNames()
   {
           $tables = $this->db->list_tables();
           return $tables;  
   }



function Is_already_register($id)
 {
  $this->db->where('email', $id);
  $query = $this->db->get('tbl_customer');
  if($query->num_rows() > 0)
  {
   return true;
  }
  else
  {
   return false;
  }
 }

 function Update_user_data($data, $id)
 {
   $this->db->where('email', $id);
    $query= $this->db->update('tbl_customer', $data);
     if($query) {
        return 1;  
     }else{
        return 0;  
     }
 }

 function Insert_user_data($data){
   $query= $this->db->insert('tbl_customer', $data);
   if($query) {
        return 1;  
     }else{
        return 0;  
     }
 }


 public function sql_single_query($sqry){
      $array_record=array(); 
      $query=$this->db->query($sqry);
      if($query->num_rows()>0){ 
      $array_record=$query->row_array();
      }
      return $array_record;   
   }
   
public function insert_user_details($data) {
        return $this->db->insert('tbl_customer', $data);
    }  
    
public function delete_user_details($id) {
        $this->db->where('customer_id', $id);
        return $this->db->delete('tbl_customer');
    }   

}

?>