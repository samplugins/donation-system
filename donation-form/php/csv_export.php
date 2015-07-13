<?PHP
/**
 * CSV Exporter
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";

if(CommonFunc::isPost())
{
    $oDonation = new modDonations(MySql::Instance());
    
    $dataset = array();
    if(isset($_POST['export_all_csv']) && $_POST['export_all_csv'] != '')
    {
        $dataset = $oDonation->CSVDataset();
    }
    else if(isset($_POST['export_selected']) && $_POST['export_selected'] != '')
    {
        if(count($_POST['donation_ids']) == 0)
        {
            CommonFunc::SetFlashMessage('error',"Please select at least one record to export.");
            header("Location: donations.php?".$_POST['qstr']."");
        }
        $dataset = $oDonation->CSVDataset($_POST['donation_ids']);
    }
    else if(isset($_POST['export_all_visible']) && $_POST['export_all_visible'] != '')
    {
        if(count($_POST['donation_ids']) == 0)
        {
            CommonFunc::SetFlashMessage('error',"No visible records to export.");
            header("Location: donations.php?".$_POST['qstr']."");
        }

        $dataset = $oDonation->CSVDataset($_POST['visible_donation_ids']);
    }
    

    $csv = new clsCSV(",","\n");
    $csv->Export($dataset,"donations-".CommonFunc::CurrentDateFileName().".csv");
    
}
else
{
    echo"Invalid request!";
}
?>