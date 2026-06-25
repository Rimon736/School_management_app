<?php
session_start();
date_default_timezone_set("Asia/Dacca");

include 'smslengthcalculatorclass.php';
class my_class{
//================ Start DB Connection 1 ==================== 

    private $host_add1="localhost";
    private $db_name1="";
    private $user_name1="root";    
    private $password1="";
	
	

    public $host_add2="localhost";
    public $db_name2="schoobee_ems_master";
    public $user_name2="root";
    public $password2="";

	
	
	
	
	    public function initialization()
    {
        
		
			// $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		/*	$a = 'How are you?';

			if (strpos($a, 'are') !== false) {
			echo 'true';
			}
			*/
			$actual_link = "$_SERVER[HTTP_HOST]";
			
			$actual_link = str_replace("www.", "", $_SERVER['HTTP_HOST']);
			$_SESSION['site']=$actual_link;
		
			//$actual_link=$_SESSION['site'];
			//$actual_link ="http://www.schoobeebd.com/smsshs";
			//$actual_link ="http://www.schoobeebd.com/greenleaf";
			
			
           //
		     $this->db_name1 =$this->verify_site($actual_link);
		
		
        //$this->db_name1 = $inst->dbname();
		
		
		


    }


	

// ==========================
public function __construct(){
 $this->con2 = new PDO("mysql:host=".$this->host_add2.";dbname=".$this->db_name2,$this->user_name2,$this->password2);  
	
$this->initialization();
$this->con1 = new PDO("mysql:host=".$this->host_add1.";dbname=".$this->db_name1,$this->user_name1,$this->password1);  
	
	
	
   
	//echo $this->con1;
}   


public function num_of_rows($table,$where_cond=1){
 $sql='SELECT count(*) as num From '.$table.' WHERE '.$where_cond ;
   $q = $this->con1->prepare($sql);
  $q->execute() or die(print_r($q->errorInfo()));
  $data = $q->fetch(PDO::FETCH_OBJ);
  return isset($data)? $data :NULL;
 }

// =============================
public function Insert_Data($table_name, $form_data) {
$fields = array_keys($form_data);

$sql = "INSERT INTO ".$table_name."
(`".implode('`,`', $fields)."`)
VALUES('".implode("','", $form_data)."')";
$q = $this->con1->prepare($sql);
$q->execute() or die(print_r($q->errorInfo()));

return $this->con1->lastInsertId();
}

public function View_Student_List_atttd_with_comment($where_cond) {
    $data = array();
    $sql = 'SELECT pf_std._id,
       sc._id AS _section_id,
       sc._name AS _section,
       cl._id AS _class_id,
       pf_std._uniq_id,
       pf_std._class_roll,
       pf_std._section_roll,
       pf_std._full_name,
       pf_std._nick_name,
       pf_std._std_mobile,
       pf_std._contact_email,
       pf_std._current_guardian,
     mot._mobile_no AS mother_phone,
     fath._mobile_no AS father_phone,
     gur._mobile_no AS guardian_phone,
       hmc._atd_status,
    hmc._late_time,
       hmc._comments
  FROM ((((((((((._int_institute_setup br
                 left JOIN _int_institute_setup i
                    ON (br._pid = i._id))
                left JOIN _int_institute_setup sh
                   ON (sh._pid = br._id))
               left JOIN _int_institute_setup me
                  ON (me._pid = sh._id))
              left JOIN _int_institute_setup cl
                 ON (cl._pid = me._id))
             left JOIN _int_institute_setup dp
                ON (dp._pid = cl._id))
            left JOIN _int_institute_setup st
               ON (st._pid = dp._id))
           left JOIN _int_institute_setup sc ON (sc._pid = st._id))
          left JOIN _pf_std_basic_info bsf
             ON (bsf._section_id = sc._id))
             
         left JOIN _pf_std_personal_info pf_std
            ON (pf_std._id = bsf._pid))
        left JOIN _int_common_setup bg
           ON (pf_std._blood_group_id = bg._id))
       left JOIN _int_common_setup rg
          ON (pf_std._religion = rg._id)
      left JOIN  _atd_daily_by_class hmc
        ON (hmc._std_id = pf_std._id AND hmc._atd_status != "P")
     left JOIN  _pf_guardian_spouse_info mot
    ON (pf_std._id = mot._pid AND mot._type = "S" AND mot._info_type = "F" )
   left JOIN  _pf_guardian_spouse_info fath
     ON (pf_std._id = fath._pid AND fath._type = "S" AND fath._info_type = "M") 
   left JOIN  _pf_guardian_spouse_info gur
     ON (pf_std._id = gur._pid AND gur._type = "S" AND gur._info_type = "O" )
       
      where '.$where_cond;
  
    $q = $this->con1->prepare($sql);
    $q->execute() or die(print_r($q->errorInfo()));
    

    while ($row = $q->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    return isset($data)? $data :NULL;    
}


// ======================
// View All Data Condition wise Function
public function View_All_By_Cond($table_name,$where_cond) {
    $data = array();
    $sql = "SELECT * FROM $table_name WHERE $where_cond";
    $q = $this->con1->prepare($sql);
    $q->execute() or die(print_r($q->errorInfo()));
    
    while ($row = $q->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    return isset($data)? $data :NULL;    
}
// ========================

// View All Data Function
public function View_All($table_name) {
    $data = array();
    $sql = "SELECT * FROM $table_name";
    $q = $this->con1->prepare($sql);
    $q->execute() or die(print_r($q->errorInfo()));
    
    while ($row = $q->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    return isset($data)? $data :NULL;    
}
// ========================



}