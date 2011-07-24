<h1>Look at all the content you've created</h1>

<table>
    <thead>
        <tr>
            <th>Actions</th>
            <th>Type</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($contents as $content):?>
        <tr>
            <td>
                <?php echo $this->Html->link('[E]', $content['Content']['edit_url']); ?>/
                <?php echo $this->Html->link('[D]', $content['Content']['delete_url']); ?>
            </td>
            <td>
               <?php echo Inflector::humanize($content['Content']['object_type']); ?> 
            </td>
            <td>
               <?php echo $this->Html->link($content['Content']['title'], $content['Content']['url']); ?> 
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

