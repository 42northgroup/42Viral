<h1>Blogs</h1>

<div id="ResultsPage">
    <?php foreach($blogs as $blog): ?>
        <h2><?php echo $this->Html->link($blog['Blog']['title'], $blog['Blog']['url']); ?></h2>
        <div class="tease">
        <?php 
            echo $this->Text->truncate(
                    $blog['Blog']['tease'], 200, array('ending' => '...', 'exact' => true, 'html' => true)); 
        ?>
        </div>
    <?php endforeach; ?>
</div>