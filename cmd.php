<?php

mysql_connect("localhost",'root',"");
mysql_select_db("imts_erp");
$sql=mysql_query("select * from imts_lead");
while($row=mysql_fetch_array($sql))
{
echo "--------------------";
$lead_id=$row['id'];
$assignto=$row['assignto'];
$assigned_date=date('Y-m-d h:i',strtotime($row['followup_date']));

echo "insert into imts_lead_history (leadid,transferedby,transferedto,transfer_date,comment,rejectedby) values($lead_id,56,$assignto,$assigned_date,'Lead Transfered',0)";
$sql1="insert into imts_lead_history (leadid,transferedby,transferedto,transfer_date,comment,rejectedby) values($lead_id,56,$assignto,'$assigned_date','Lead Transfered',0)";

//echo "update imts_lead set assigned_date='$assigned_date' where id='$lead_id'";
//$sql1="update imts_lead set assigned_date='$assigned_date' where id='$lead_id'";
$query1=mysql_query($sql1);
}
?>
