# ACL(Access Control Lists)

ACLs are what allows administrators to restrict or grant users access to certain parts of the system.

## Users

An administrator can grant or deny access to users by going to:

    Admin
        System
        -Users
        
and clicking on the "Privs" link for the specific user. There the admin will see a list of all controllers and actions
in the system, including plugins, laid out in the following manner "Controller -> Action". From there the admin can 
grant or deny privileges specific for the user, or they can add the user to a group by clicking on the "Join Group" link
at the top of the page and selecting a group from the dropdown. Once A user is added to a group, they will automatically
inherit all the privileges of that group.

## Developers

All the code for dealing with ACLs can be found in the Privileges controller. Whether we are building the initial ACL 
permissions for the ROOT user of dealing with permissions for a regular system user, the methodology is almost exactly 
the same.

    First we use the ControllerList component the get a list of all controllers and their actions 
    (including plugin controllers) in the system.
    
    We loop through that list and check if there is an entry in the acos table for every Controller->Action. If there is
    a Controller->Action for which there is no entry, we use the CakePHP ACL component to create one.

    When we display the permission grid for a user or group we query the aros_acos table to get the permissions a user 
    or group currently has.
    
    When we are fetching the list of permissions, if a permission for a certain Controller -> Action is set to 
    0(inherited) we check the group the user belongs to, to get that permission.
    
    Once the permissions form has been submitted, we loop through the data array and grant or deny to access for the 
    user to the specific Controller->Action using the CakePHP Acl component.
    
    When we are adding the user to a group, we get a list of all controllers and their actions (including plugin 
    controllers), we loop through that list and use the Acl component's inherit function to give the user all the same
    permissions as the group.