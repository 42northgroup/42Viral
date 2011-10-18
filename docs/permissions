# Permissions

The goal is to make permissions as fine grained and flexible as possible
without being difficult to use. Permissions are derived using a combination of 
Session, ACLs and Ownership. 

## Session Control 

Session permissions are handled using the AuthComponent. The idea here is to 
determine which controller actions are public (open to all traffic) and which 
of those require and authenticated user. This call is made using the 
AppAbstractController's auth method. The security model is restrictive by 
default.

Placing this is the controller would allow public access to all actions in that
controller.

    $this->auth(array('*'));

Placing this is the controller would require an authenticated user for 
accessing any of the actions in a single controller 

    $this->auth(); 


Placing this is the controller would require allow public access to the index 
action while requiring an authenticated user for accessing anything of the 
controllers other actions. 

    $this->auth(array('index'));

At this point your probably thinking this looks a lot like the auth component.

    $this->Auth->allow('*');
    $this->Auth->allow('index');
    $this->Auth->deny('*');

And you would be right. $this->auth() simply encapsulates these methods and 
adds ACL control.

## ACL Control

The 42Viral Project takes advantage of CakePHP's ACLs (ARO/ACO). Our model 
allows us to specify exactly what actions each user has access to. We make 
this easy to manage by defining permission groups. Each user would inherit the
permissions of a single group. At this point that user can be tweaked by having
permissions added or taken away. The auth method is also encapsulates this 
functionality by comparing the authenticated session's user name to the aros 
acos tables. 