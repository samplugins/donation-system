<?PHP
/**
 * View Contact Requests
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
?>
<?PHP require_once"include/init.php"; ?>
<?PHP include"web.parts/header.php"; ?>
    <h2>Donations</h2>  
    <form name="filterfrm" id="filterfrm" action='donations.php' method="get">
        <fieldset>
            <legend onclick="$('#search_form_options').toggle()" class="cursor">Search Options</legend>
            <div id="search_form_options" style="display:none;">
                <p><label>Donation ID</label><input type="text" name="donation_id" class="text" value="<?PHP  if(isset($_GET['donation_id'])) echo $_GET['donation_id']?>" /></p>
                <p><label>First Name</label><input type="text" name="first_name" class="text" value="<?PHP  if(isset($_GET['first_name'])) echo $_GET['first_name']?>" /></p>
                <p><label>Last Name</label><input type="text" name="last_name" class="text" value="<?PHP  if(isset($_GET['last_name'])) echo $_GET['last_name']?>" /></p>
                <p><label>Email</label><input type="text" name="email" class="text" value="<?PHP  if(isset($_GET['email'])) echo $_GET['email']?>" /></p>
                <p><label>From Date <small>(YYYY-MM-DD)</small></label><input type="text" id="date_from" name="date_from" class="text date_input" value="<?PHP  if(isset($_GET['date_from'])) echo $_GET['date_from']?>" /></p>
                <p><label>To Date <small>(YYYY-MM-DD)</small></label><input type="text" id="date_to" name="date_to" class="text date_input" value="<?PHP  if(isset($_GET['date_to'])) echo $_GET['date_to']?>" /></p>
                 <p><label>Payment Status</label>
                   <select id="country" name="status_id">
                        <option value=""> -- View All -- </option>
                        <?PHP
                        echo clsDonationStatus::Instance()->Combo($_GET['status_id']);
                    ?>
                    </select>
                    
                </p>   
                <p><label>Order By</label>
                    <select name='order_by' id='order_by' class="select">      
                        <?PHP
                        echo clsArray::arrayToComboOptions(modDonations::OrderFields(),$_GET['order_by']);
                        ?>

                    </select> 
                    
                </p>   
                <p><label>Order Direction</label>

                    
                     <select name='order_direction' id='order_direction' class="select">      
                        <?PHP
                        $options = array();     
                        $options['desc'] = "DESC";
                        $options['asc'] = "ASC";
                        
                        echo clsArray::arrayToComboOptions($options,$_GET['order_direction']);
                        ?>

                    </select>
                </p>
                
                
                 <p><label>Per Page</label>
                    
                     <select name='per_page' id='per_page' class="select">   
                        <?PHP
                        $options = array();     
                        $options['50'] = "50";
                        $options['100'] = "100";
                        $options['150'] = "150";
                        $options['200'] = "200";
                        $options['250'] = "250";
                        $options['300'] = "300";
                        $options['400'] = "400";
                        $options['500'] = "500";
                        $options['1000'] = "1000";
                        
                        echo clsArray::arrayToComboOptions($options,$_GET['per_page']);
                        ?>

                    </select>
                </p>
                 <div align="center"><input name="btn" type="submit" value="Search" class="btn" /></div> 
            </div>
             
        </fieldset>
    </form>
    
    <?PHP CommonFunc::RenderFlashMessage(); ?>
    
    <?PHP    
    $oDonations = new modDonations(MySql::Instance());

    
    $paging = $oDonations->PagedDataSet($_GET);
    if($paging->hasRows()):
    ?>
    <form method="post" action="csv_export.php">
        <input type="hidden" name="qstr" value="<?PHP echo http_build_query($_GET); ?>" />
  
    <table cellpadding="0" cellspacing="0" width="100%" class="main">
        <thead>
        <tr>
            <th width="2%" align="left"><input type='checkbox' name='checkall' onclick='checkUncheckAll(this);' class="check_radio" /></th>
            <th width="15%" align="left">First Name</th>
            <th width="15%" align="left">Last Name</th>
            <th width="10%" align="center">Email</th>
            <th width="20%" align="center">Date</th>
            <th width="10%" align="center">Amount</th> 
            <th width="20%" align="center">Status</th>
            <th width="28%" align="center">Action</th>
        </tr>
        </thead>
        <tbody>
        <?PHP 
        $i=0;
        while($donation = MySql::Instance()->myArray($paging->result)): 
            $class = CommonFunc::tr_class($i);
    
        ?>
        <tr class="<?PHP echo $class; ?>">
            <td width="2%">
                <input type='hidden' name='visible_donation_ids[]' value='<?=$donation['donation_id']?>' />
                <input type='checkbox' name='donation_ids[]' value='<?=$donation['donation_id']?>' class="check_radio" /></td>
            <td align="left"><?PHP echo $donation['first_name']; ?></td>
            <td align="left"><?PHP echo $donation['last_name']; ?></td>
            <td align="center"><?PHP echo $donation['email']; ?></td>  
            <td align="center"><?PHP echo CommonFunc::getFormatedDateTime( $donation['donation_date']); ?></td>
            <td align="center"><?PHP echo $donation['amount']; ?></td>
            <td align="center"><?PHP echo ucWords($donation['status_id']); ?></td>
   
            <td align="center">
                <a title="View" onclick="return GB_showFullScreen('Request#<?PHP echo $donation['donation_id']; ?>', '../../../php/view.php?id=<?PHP echo $donation['donation_id']; ?>')" class="btn"><img src='../assets/images/edit.gif' /></a>
                <a Title="Delete" onclick="return confirm('Are you sure you wish to delete this entry?');" href="delete_donation.php?id=<?PHP echo $donation['donation_id']; ?>" class="btn"><img src='../assets/images/deleteicon.gif' /></a>
            </td>
        </tr>
        <?PHP $i++; endwhile; ?>
        </tbody>
    </table>
        
         <div align="center">
            <input type="submit" name="export_selected" value="Export Selected Records" class="btn" />
            <input type="submit" name="export_all_visible" value="Export Visible Records" class="btn" />
            <input type="submit" name="export_all_csv" value="Export ALL Records" class="btn" /><br /><br />
       </div>
    
    
    </form>
    
     <div align="center">
        <?PHP echo $paging->render(); ?>
    </div>
    <?PHP else: ?>
    <p>No donations found</p>
    <?PHP endif; ?>
<?PHP include"web.parts/footer.php"; ?>