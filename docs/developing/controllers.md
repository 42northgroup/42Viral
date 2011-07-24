Controllers
===========

The 42Viral Project ships with a number of pre-built controllers. In contrast to a native CakePHP application the 
controllers do not extend from AppController rather they extend from an abstract abstract controller. For example
the UsersController would extend from UsersAbstractController. All controller functionality for The 42Viral Project
lives in these abstract controllers. This allows you to easily extend and override the The 42Viral Project's core 
functionality without making upgrades completely infeasible. 

If your creating your own controller, you can extend any abstract controller simply extend the AppController as you
normally would when building a CakePHP application. 

