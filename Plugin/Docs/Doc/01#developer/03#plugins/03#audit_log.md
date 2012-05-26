# AuditLog Plug-in

Creates an audit history for each instance of a model to which it's attached. AuditLog tracks changes on two levels. It 
takes a snapshot of the fully hydrated object _after_ a change is complete and it also records each individual change in 
the case of an update action.

To AuditLog is powered by the Auditable behavior. To make a given model auditable simply add the behavior to the model.

    public $actsAs = array(
        'AuditLog.Auditable'
    );
