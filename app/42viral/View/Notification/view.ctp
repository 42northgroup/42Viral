<h1>Notification - View</h1>

<div class="">
    <a href="/notification/index">Index<a/>
    /
    <a href="/notification/create">Create<a/>
    /
    <a href="/notification/edit/<?php echo $notification['Notification']['id']; ?>">Edit</a>
    /
    <a href="/notification/delete/<?php echo $notification['Notification']['id']; ?>"
       class="delete-confirm">Delete</a>
    /
    <a href="/notification/test/<?php echo $notification['Notification']['id']; ?>">Test Fire</a>
</div>

<table>
    <tbody>
        <tr>
            <td>
                Alias
            </td>

            <td>
                <?php  echo $notification['Notification']['alias']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Name
            </td>

            <td>
                <?php  echo $notification['Notification']['name']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Subject Template
            </td>

            <td>
                <?php  echo $notification['Notification']['subject_template']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Body Template
            </td>

            <td>
                <?php  echo $notification['Notification']['body_template']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Active
            </td>

            <td>
                <?php  echo ($notification['Notification']['active'])? 'Yes': 'No'; ?>
            </td>
        </tr>
    </tbody>
</table>
