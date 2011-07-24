Behaviors
=========

The 42Viral Project ships with a number of core behaviors

## PicklistBehavior

The PicklistBehavior is used for defining system level lists. That is to say these lists are critical to systems 
operation so these are defined in code to keep them away from the control of the users. 

Lists are defined as an array. 

    array(
        'Picklist' => array(
            'some_list' => array(
                'option_number_one' => 'Option Number One',
                'option_number_two' => 'Option Number Two'
            )
         )
    );

The naming convention for the key to value pairing requires the key to be a lowercase, underscored version of it's value
. This is important because we often use Inflector::humanize() to render the key itself into a view.