<?php

$ldapserver = "ldaps://host.domainName.topLevelDomain"; // This is the Windows domain controller we are authenticating to.  Include the quotes.  Ex; $ldapserver = "ldaps://c.kagadis.com"
$ldapuser      = "domainName\userAccount"; // This is the valid Windows user account.  Include the quotes.
$ldappass     = "userAccountPassword"; // This is the Windows account's password.  Include the quotes.

$ldaptree    = "OU=userContainer,DC=domainName,DC=topLevelDomain"; // This is the LDAP user search base.  Include the quotes.  Ex; $ldaptree    = "OU=users,DC=kagadis,DC=com";
$ldapconn = ldap_connect($ldapserver) or die("Could not connect to LDAP server.");
$employeeName = "*string*"; // This the who we're looking for, place the string between the astericks, include the quotes.  Ex; $employeeName = "*kagadis*";

if($ldapconn)
{
	$ldapbind = ldap_bind($ldapconn, $ldapuser, $ldappass) or die ("Error trying to bind: ".ldap_error($ldapconn));

	if ($ldapbind)
	{
		$result = ldap_search($ldapconn,$ldaptree,"(cn=$employeeName)") or die ("Error in search query: ".ldap_error($ldapconn));
		$data = ldap_get_entries($ldapconn, $result);

		echo '<h1>User List</h1>';
		for ($i=0; $i<$data["count"]; $i++) {
			echo "dn is: ". $data[$i]["dn"] ."<br />";
			echo "User: ". $data[$i]["cn"][0] ."<br />";
			$objectguid = $data[$i]["objectguid"][0];
			$objectguid = bin2hex($objectguid);
			echo "GUID: " .$objectguid . "<br>";
			$_SESSION['thumbnailphoto'] = $data[$i]["thumbnailphoto"][0];
			$thumbnailphoto = $_SESSION['thumbnailphoto'];
			file_put_contents($tempFile, $thumbnailphoto);
			if(isset($data[$i]["mail"][0]))
			{
				echo "Email: ". $data[$i]["mail"][0] ."<br />";
			}
			else
			{
				echo "Email: None<br />";
			}
			if(isset($data[$i]["ipphone"][0]))
			{
				echo "Extension: ". $data[$i]["ipphone"][0] ."<br /><br />";
			}
			else
			{
				echo "Extension: None<br /><br />";
			}
			if (isset($thumbnailphoto))
			{
				echo "<img src='data:" . $mime[0] . ';base64,' . base64_encode($thumbnailphoto) . "'/><br><br>";
			}
		}
		echo "Number of entries found: " . ldap_count_entries($ldapconn, $result);
	}
	else
	{
		echo "LDAP bind failed...";
	}
}

ldap_close($ldapconn);

?>
