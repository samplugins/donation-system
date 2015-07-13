<?PHP
/**
 * Pagination Class
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsPaging
{
	
	public $paging_output = NULL;
	public $db = NULL;
	
	public $result = NULL;
	
	public $total = 0;
	
	public $limit = 25;
	public $adjacents = 2;
	
	public $css_class = "pagination";
	
	public $page_records = 0;

	public $hide_numbers = 0;
	
    function db()
    {
        return MySql::Instance();
    }
    
	function __construct($limit=0,$adjacents=0){

            $this->limit = isset($_GET['per_page']) ? $_GET['per_page'] : $limit;
		
            if($this->limit == 0 )
            {
                $this->limit = 50;
            }

            if($adjacents > 0 ){
                    $this->adjacents = $adjacents;
            }
	}
	
	function render()
    {
		if($this->paging_output != NULL){
			return $this->paging_output;
		}
	}
    
    function hasRows()
    {
        return $this->db()->NumRows($this->result);
    }

	/*
		$sql= "SELECT * FROM TABLE"
		$db = DB OBJECT
	*/
	function _do($_sql,$targetpage="",$queryvars = '',$is_ajax=false){
		/* 
		   First get total number of rows in data table. 
		   If you have a WHERE clause in your query, make sure you mirror it here.
		*/
        

            $total_pages = $this->db()->QuickCount($_sql);

            $this->total = $total_pages;
		
            $show_all = false;
            if($_GET['page'] == "all" || $this->limit == "0"){
                $show_all = true;  
            }

                $sql = $_sql;
        
		$prev = '';
		$next = '';                       
		$lastpage = '';
		$lpm1 = '';
		

        if($show_all == false)
        {
            
		    $page = (int) $_GET['page'];
		    if($page) 
			    $start = ($page - 1) * $this->limit; 			//first item to display on this page
		    else
			    $start = 0;								//if no page var is given, set start to 0
		    

		    $sql = $_sql." LIMIT $start, ".$this->limit."";

		    $this->page_records = $this->db()->QuickCount($sql);
		        
		        
		    if($this->page_records == 0)
			    $sql = $_sql." LIMIT 0, ".$this->limit."";
            
            
            /* Setup page vars for display. */
            if ($page == 0 || $this->page_records == 0) {
                $page = 1;                    //if no page var is given, default to 1.
            }
			
            $prev = $page - 1;                            //previous page is page - 1
			$next = $page + 1;                            //next page is page + 1
			$lastpage = ceil($total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;                        //last page minus 1
        
        }else
        {
            $lastpage = 2;
        }
        

		$this->result = $this->db()->query($sql);

        
        $query_params = '';
         if($queryvars != ''){
            $query_params = "?" . $queryvars;
            if(substr($queryvars ,-1) != "&"){  // make sure to append "&"
                $query_params .= "&";
            }
        }else{
            $query_params = "?";
        }
        
        if(strstr($targetpage,"?")){ 
            $query_params = ltrim($query_params,"?");
        }
        
        $query_params = str_replace("?&","?",$query_params);
		
		if(isset($_GET['per_page']))
		{
			$query_params .= "per_page=".$_GET['per_page']."&";
		}

	
		$pagination = "";


		if($lastpage > 1)
		{	
			$pagination .= "<div class=\"".$this->css_class."\">";
			//previous button
			if ($page > 1) 
				$pagination.= "<a href=\"$targetpage".$query_params."page=$prev\">previous</a>";
			else
				$pagination.= "<span class=\"disabled\">previous</span>";	
			    

				$middle_string = '';
				//pages	
				if ($lastpage < 7 + ($this->adjacents * 2))	//not enough pages to bother breaking it up
				{	
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$middle_string.= "<span class=\"current\">$counter</span>";
						else
							$middle_string.= "<a href=\"$targetpage".$query_params."page=$counter\">$counter</a>";					
					}
				}
				elseif($lastpage > 5 + ($this->adjacents * 2))	//enough pages to hide some
				{
					//close to beginning; only hide later pages
					if($page < 1 + ($this->adjacents * 2))		
					{
						for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$middle_string.= "<span class=\"current\">$counter</span>";
							else
								$middle_string.= "<a href=\"$targetpage".$query_params."page=$counter\">$counter</a>";					
						}
						$middle_string.= "...";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=$lpm1\">$lpm1</a>";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=$lastpage\">$lastpage</a>";		
					}
					//in middle; hide some front and some back
					elseif($lastpage - ($this->adjacents * 2) > $page && $page > ($this->adjacents * 2))
					{
						$middle_string.= "<a href=\"$targetpage".$query_params."page=1\">1</a>";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=2\">2</a>";
						$middle_string.= "...";
						for ($counter = $page - $this->adjacents; $counter <= $page + $this->adjacents; $counter++)
						{
							if ($counter == $page)
								$middle_string.= "<span class=\"current\">$counter</span>";
							else
								$middle_string.= "<a href=\"$targetpage".$query_params."page=$counter\">$counter</a>";					
						}
						$middle_string.= "...";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=$lpm1\">$lpm1</a>";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=$lastpage\">$lastpage</a>";		
					}
					//close to end; only hide early pages
					else
					{
						$middle_string.= "<a href=\"$targetpage".$query_params."page=1\">1</a>";
						$middle_string.= "<a href=\"$targetpage".$query_params."page=2\">2</a>";
						$middle_string.= "...";
						for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$middle_string.= "<span class=\"current\">$counter</span>";
							else
								$middle_string.= "<a href=\"$targetpage".$query_params."page=$counter\">$counter</a>";					
						}
					}
				}
				
			if($this->hide_numbers == 0 ) { 
				
				$pagination .= $middle_string;
				
			}
			
			//next button
			if ($page < $counter - 1) 
				$pagination.= "<a href=\"$targetpage".$query_params."page=$next\">next</a>";
			else
				$pagination.= "<span class=\"disabled\">next</span>";
                

            if($show_all == false)   
            {
                $pagination .= "<a href=\"$targetpage".$query_params."page=all\">View All</a>";  
            }else{
                $pagination = "<div class=\"".$this->css_class."\">";   
                $pagination .= "<a href=\"$targetpage".$query_params."page=1\">Paginate</a>";  
            }
                
			$pagination .= "</div>\n";		
		}
      
		
		
		$this->paging_output = $pagination;
	}

	
}


?>