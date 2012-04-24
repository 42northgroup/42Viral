# CalendarRecursion Plug-in

This plug-in can be used to quickly generate date/time instances for a given range of dates with parameters such as
which days of the week you want the dates to be generated for. This becomes very useful in calendaring applications
for generating and blocking out dates on a calendar.

`CalendarRecursion` should always be used with an additional third model! The examples provided here use a model called
Activity.

First thing you need to do is create all instances of the additional model that you are going to need. For example if
you want to have `CalendarRecursion` for something that will happen twice a week for the next 6 weeks, you need to
create 12 instances of the third-party model. Let's look at a more practical example.

### Creating the instances for the third-party model

Lets say we want to create a `CalendarRecursion` for an activity that happens every Monday and Thursday between 7pm and
8pm form June 1st 2012 to June 30th 2012. There are 4 Mondays and 4 Thursdays between those 2 dates so we will need to
create 8 instances of the Activity model. We need to create the Activity instances first, because we need to pass their
IDs into the `CalendarRecursion` creation function. If the third party model needs dates for its instances(in this case
Activity does) you can use the `expandCalendarRecursion` function inside the `CalendarRecursion` model to get dates you
will need. You need to call that function with the following arguments:

    - Start date(String)
    - End date(String)
    - Days of the week(Sting, comma separated)

    $this->CalendarRecursion->expandCalendarRecursion(
        '06/01/2012 7pm',
        '06/3/2012 8pm',
        'Monday, Thursday'
    );

The call above would return the following:

    Array => (
        [0] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-04 19:00:00'
                [end_time] => '2012-06-04 20:00:00'
            )
        )

        [1] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-07 19:00:00'
                [end_time] => '2012-06-07 20:00:00'
            )
        )

        [2] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-11 19:00:00'
                [end_time] => '2012-06-11 20:00:00'
            )
        )

        [3] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-14 19:00:00'
                [end_time] => '2012-06-14 20:00:00'
            )
        )

        [4] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-18 19:00:00'
                [end_time] => '2012-06-18 20:00:00'
            )
        )

        [5] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-21 19:00:00'
                [end_time] => '2012-06-21 20:00:00'
            )
        )

        [6] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-25 19:00:00'
                [end_time] => '2012-06-25 20:00:00'
            )
        )

        [7] => array(
            [CalendarInstance] => array(
                [start_time] => '2012-06-28 19:00:00'
                [end_time] => '2012-06-28 20:00:00'
            )
        )
    );

### Creating the CalendarRecursion

After we have created all instances for the Activity model, we need to get their IDs. We can query the Activity model
right after we create all the instances or we can give it the `ReturnInsertedIds` behavior prior to creating the
instances and then `$insetedIds` array in the `AppModel` will be automatically populated with the IDs of the created
instances. Once we have the IDs, all we need to do is call the `createRecursion` function inside the `CalendarRecursion`
model and pass it the following arguments:

    - Start date(same as in the `expandCalendarRecursion` function)
    - End date(same as in the `expandCalendarRecursion` function)
    - Days of the week, comma separated(same as in the `expandCalendarRecursion` function)
    - Name of the third party model(in our case "Activity")
    - An array that holds the IDs of all third party model instances(lets call it $activities_ids in this case),
    - A string that describes the `CalendarRecursion` (for example 'Washing Dishes')

    $this->CalendarRecursion->createRecursion(
        '06/01/2012 7pm',
        '06/30/2012 8pm',
        'Monday, Thursday',
        'Activity',
        $activity_ids,
        'Washing Dishes'
    );

Calling this function will create one instance in the calendar_recursions table and one instance FOR EACH Activity
instance in the calendar_instances table. Now there is one last thing you need to do if your third party
model takes dates for each instance. You need to give it the behavior of `CalendarDayDateSync` and pass the names of the
columns that hold the start and end date/time for each instance. The reason we do that, is because if a date changes in
the Activity model, we want to make sure we sync that date with its corresponding `CalendarInstance`. Example:

    public $actsAs = array(
        'CalendarDayDateSync' => array(
            //Name of start date/time column in table for Activity model
            'start' => 'start_date',

            //Name of end date/time column in table for Activity model
            'end' => 'end_date'
        )
    );