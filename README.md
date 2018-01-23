Author's Note:
--------------
BEFORE USING ANY CODE IN THESE SCRIPTS, READ THROUGH ALL FILES THOROUGHLY, UNDERSTAND WHAT THE SCRIPTS ARE DOING AND TEST THEIR BEHAVIOR IN AN ISOLATED ENVIRONMENT.  RESEARCH ANY POTENTIAL BUGS IN THE VERSION OF THE SOFTWARE YOU ARE USING THESE SCRIPTS WITH AND UNDERSTAND THAT FEATURE SETS OFTEN CHANGE FROM VERSION TO VERSION OF ANY PLATFORM WHICH MAY DEPRECATE CERTAIN PARTS OF THIS CODE.  ANY INDIVIDUAL CHARGED WITH RESPONSIBILITY IN THE MANAGEMENT OF A SYSTEM RUNS THE RISK OF CAUSING SERVICE DISRUPTIONS AND/OR DATA LOSS WHEN THEY MAKE ANY CHANGES AND SHOULD TAKE THIS DUTY SERIOUSLY AND ALWAYS USE CAUTION.  THIS CODE IS PROVIDED WITHOUT ANY WARRANTY WHATSOEVER AND IS INTENDED FOR EDUCATIONAL PURPOSES.  

Basic LDAP Authentication code for CUCM Apps
============================================

Whether you're writing an application for remote controlling phones or putting together your own Call Detail Records solution, user authentication and privilege management is a priority.  Microsoft Windows Active Directory remains one of the more popular systems for managing users, so if your plan is to write an application that will leverage authentication to a domain controller via web browser, this can be done fairly easily via secure LDAP and PHP.  

The following script is a bare bones example of authentication to a domain controller via secure LDAP.  Sections that need to be modified for each environment have been annotated.  The script will look for any string set in $employeeName and will pull the following objects from AD;

* The user's dn
* The user's cn
* The user's objectguid
* The user's email address
* The user's ipphone (which is often filled in for enviroments using Active Directory-synchronized CUCM systems)
* The user's thumbnailphoto

The objectguid in particular is important because, besides authentication, it should be used as the basis for privilege management.  For example; a debian server that has apache2, php5, and mysql can be set up to contain a local database table that uses a user's objectguid for privileges.  Objectguid strings, which are randomly generated at the time of account creation, are unique (perfect for privilege management) whereas usernames can be recycled (useless for privilege management, especially as employees leave and new workers may assume old usernames).

This script also pulls a user's thumbnailphoto information and display it on the page (in case you're interested).

If you are able to pull information from ldap based on the string you added in "$employeeName", congratulations - your script is connecting properly and you can now modify it for your needs.

Tested on:
----------
* Debian 7
* PHP 5
