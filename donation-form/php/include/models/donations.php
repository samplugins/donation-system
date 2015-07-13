<?PHP
class modDonations 
{
    private $_db;
        
    function __construct($db = null)
    {
        if($db == null)
        {
            $db = Mysql::Instance();
        }
        $this->_db = $db;
    }
    
    function GetPendingDonationID($session_id)
    {
        $sql = "SELECT donation_id FROM donations WHERE  session_id = '".CommonFunc::safe($session_id)."' AND status_id = '".clsDonationStatus::PENDING."' ";   
        $a = $this->_db->QuickArray($sql);        
        return (int)$a[0];
    }
    
    function getPendingDonationData($session_id)
    {
        $sql = "SELECT * FROM donations WHERE  session_id = '".CommonFunc::safe($session_id)."' AND status_id = '".clsDonationStatus::PENDING."' ";   
        return $this->_db->QuickArray($sql);        
    }
    
    function Save(modDonationBO $obj)
    {
        if($obj->donation_id > 0)
        {
            return $this->Update($obj);
        }
        else
        {
            return $this->Create($obj);
        }
    }
    
    function Create(modDonationBO $obj)
    {
        $sql = "INSERT INTO donations SET "; 
        $sql .= " session_id = '".CommonFunc::safe($obj->session_id)."', "; 
        $sql .= " first_name = '".CommonFunc::safe($obj->first_name)."', ";  
        $sql .= " last_name = '".CommonFunc::safe($obj->last_name)."', ";  
        $sql .= " email = '".CommonFunc::safe($obj->email)."', "; 
        $sql .= " amount = '".$obj->amount."', "; 
        $sql .= " payment_method = '".$obj->payment_method."', "; 
        $sql .= " donation_date = now(), "; 
        $sql .= " ip_address = '".$_SERVER['REMOTE_ADDR']."', "; 
        $sql .= " status_id = '".CommonFunc::safe($obj->status_id)."' "; 
        
        $q =  $this->_db->query($sql);
       
       if($q){
            return $this->_db->getInsertID();
       }else{
           return false;
       }
    }    
     
    function Update(modDonationBO $obj)
    {
        $sql = "UPDATE donations SET ";
        $sql .= " session_id = '".CommonFunc::safe($obj->session_id)."', "; 
        $sql .= " first_name = '".CommonFunc::safe($obj->first_name)."', ";  
        $sql .= " last_name = '".CommonFunc::safe($obj->last_name)."', ";  
        $sql .= " email = '".CommonFunc::safe($obj->email)."', "; 
        $sql .= " amount = '".$obj->amount."', "; 
        $sql .= " payment_method = '".$obj->payment_method."', "; 
        $sql .= " donation_date = now(), "; 
        $sql .= " ip_address = '".$_SERVER['REMOTE_ADDR']."', "; 
        $sql .= " status_id = '".CommonFunc::safe($obj->status_id)."' "; 
        
        $sql .= " WHERE donation_id = '".(int)$obj->donation_id."' "; 
 
        $q = $this->_db->query($sql);
        if($q)
        {
            return $obj->donation_id;
        }
        else
        {
            return false;
        }
    }   
    
    
    function UpdateStatus($status_id,$donation_id)
    {
        $sql = "UPDATE donations SET ";           
        $sql .= " status_id = '".CommonFunc::safe($status_id)."', ";     
        $sql .= " status_updated_on = now() ";     
        $sql .= " WHERE donation_id = '".(int)$donation_id."' ";                     
        return $this->_db->query($sql);
    }  
    
    function isValidOrderField($k)
    {
        $orderFields = self::OrderFields();
        
        if(isset($orderFields[$k]))
            return true;
        return false;
    }
    
    static function OrderFields()
    {
        $options = array();
        
        $options['donation_id'] = "Donation#";
        $options['first_name'] = "First Name";
        $options['last_name'] = "Last Name";
        $options['email'] = "Email";
        $options['amount'] = "Amount";
        $options['donation_date'] = "Date";    
        
        return $options;     
    }
         

    function Row($donation_id)
    {
         return $this->_db->QuickArray("SELECT d.*
                FROM donations d 
                WHERE d.donation_id ='".(int)$donation_id."'");
    } 
    
    function Delete($donation_id)
    {
        if($donation_id)
        {
            $this->_db->query("DELETE FROM donations WHERE donation_id  = '".(int)$donation_id."'");
            return $this->_db->getAffectedRows();
        }
        return 0;
    }
    
    function DeleteSelectedDonations($_array)
    {
        if(is_array($_array))
        {
            $this->_db->query("DELETE FROM donations WHERE donation_id IN (".implode(",",$_array).")");
            return $this->_db->getAffectedRows();
        }
        return 0;
    }
    
    function DataSet($data=array())
    {
        return $this->_db->dataset($this->getSQL($data));
    }
    
    function PagedDataSet($data=array())
    {
        $clsPaging = new clsPaging();
        $clsPaging->_do($this->getSQL($data));
        
        return $clsPaging;
    }
    
    function CSVDataset($donation_id=array())
    {
        $sql = "SELECT * FROM donations   ";
        if(count($contact_ids))
        {
            $sql .= " WHERE donation_id IN (".implode(',',$donation_id).")";
        }
        
        $sql .= ' ORDER by donation_date DESC';

        
        $q = $this->_db->query($sql);

        $dataset = array();
        while($r = $this->_db->myArray($q)){
            
            $row = array();
            
            unset($r['donation_transaction_data']);
            unset($r['session_id']);
            
            foreach($r as $key=>$value)
            {
                $row[strtoupper($key)] = $value;
            }
            $dataset[] = $row;
        }

        return $dataset;
    }
    
    function getSQL($data=array())
    {
   
        $sql = "SELECT d.* FROM donations d ";            
        $sql .= " WHERE d.donation_id > 0"; 
        
        if(isset($data['donation_id']) && $data['donation_id'] != "")
        {
           $sql .= " AND d.donation_id = '".(int)$data['donation_id']."'";
        }
        
        if(isset($data['amount']) && $data['amount'] != "")
        {
           $sql .= " AND d.amount = '".CommonFunc::safe($data['amount'])."'";
        }
        
        
        if(isset($data['status_id']) && $data['status_id'] != "")
        {
           $sql .= " AND d.status_id = '".  CommonFunc::safe($data['status_id'])."'";
        }
        
        
        if(isset($data['first_name']) && $data['first_name'] != "")
        {
           $sql .= " AND d.first_name like '%".CommonFunc::safe($data['first_name'])."%'";
        }
       
        
        if(isset($data['last_name']) && $data['last_name'] != "")
        {
           $sql .= " AND d.last_name like '%".CommonFunc::safe($data['last_name'])."%'";
        }
        
 
        if(isset($data['email']) && $data['email'] != "")
        {
           $sql .= " AND d.email = '".CommonFunc::safe($data['email'])."'";
        }
        

        if(isset($data['date_from']) && $data['date_from'] != "")
        {
            $sql .= " AND  STR_TO_DATE(d.donation_date,'%Y-%m-%d') >= '".CommonFunc::safe($data['date_from'])."'";
        }
         
        if(isset($data['date_to']) && $data['date_to'] != "")
        {

            $sql .= " AND  STR_TO_DATE(d.donation_date,'%Y-%m-%d') <= '".CommonFunc::safe($data['date_to'])."'";
        }

        if(isset($data['order_by']) && $data['order_by'] != '' && $this->isValidOrderField($data['order_by']))
        {
             $sql .= " ORDER BY d.".$data['order_by']." ";    
        }
        else
        {
             $sql .= " ORDER BY d.donation_id ";     
        }
        
        if(isset($data['order_direction']) && ($data['order_direction'] == 'asc' || $data['order_direction'] == 'desc'))
        {
             $sql .= " ".$data['order_direction']." ";    
        }
        else
        {
             $sql .= " DESC ";  
        }

        return $sql;
    
    }
    
    function logDonationTransactionData(array $merchantData,$donation_id)
    {
        $sql = "UPDATE donations SET ";           
        $sql .= " donation_transaction_data = '".json_encode($merchantData)."' ";     
        $sql .= " WHERE donation_id = '".(int)$donation_id."' ";                     
        return $this->_db->query($sql);
    }  

}


?>