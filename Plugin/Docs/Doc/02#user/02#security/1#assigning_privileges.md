# Assigning Privileges

Privileges in The 42Viral Project are assigned at the controller/action level using Access Control Lists and Groups.

ACLs are what allows administrators to restrict or grant users access to certain parts of the system.

An administrator can grant or deny access to users by going to:

    Admin
        System
        - Users

and clicking on the **Privs** link for the specific user. There the admin will see a list of all controllers and actions
in the system, including plug-ins, laid out in the following manner `Controller->Action`. From there the admin can
grant or deny privileges specific for the user, or they can add the user to a group by clicking on the "Join Group" link
at the top of the page and selecting a group from the drop-down. Once A user is added to a group, they will
automatically inherit all the privileges of that group.