Models
===========

The 42Viral Project ships with a number of pre-built models. In contrast to a native CakePHP application the 
models do not extend from AppModel rather they extend from an abstract abstract model. For example
the User would extend from UserAbstract. All model functionality for The 42Viral Project
lives in these abstract models. This allows you to easily extend and override the The 42Viral Project's core 
functionality without making upgrades completely infeasible .  

