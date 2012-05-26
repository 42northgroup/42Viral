# PicklistManager Plug-in

An easy way to generate and manage picklists and picklist options for use with HTML select form element.

This plug-in provides a basic CRUD management UI for creating and managing picklists and their corresponding options.
Picklists can be accessed through their ID or a given name (alias). Groupings can be specified for picklist options and
the API allows for different ways to fetch these picklists.

Usage:

    //Add the picklist model to the relevant controller's `$uses` array:
    public $uses = array(
        'PicklistManager.Picklist'
    );

    //Query the picklist by its given name (alias) and specify your desired options.
    $list = $this->Picklist->fetchPicklistOptions('my_custom_picklist', array(
        'emptyOption'=>false,
        'otherOption'=>false
    ));

    //Set any desired template variable to populate a form select element
    $this->set('my_list', $list);

    
    //In your template either pass to form helper or loop and generate the appropriate HTML <select> <option> elements
    echo $this->Form->select('Picklist', $my_list, array(
        'empty' => false
    ));
    
For detailed usage options and API methods check out the API documentation.