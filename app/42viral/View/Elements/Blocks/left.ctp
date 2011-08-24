<ul class="side-navigation">
    <li><a href="/pages">Pages</a></li>
    <li><a href="/blogs">Blogs</a></li>
    <li><a href="/members">Members</a></li>
    <li><a href="/admin/users/">Users Index</a></li>
</ul>

<?php if($this->Session->check('Auth.User.id')): ?>
    <?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'contents'); ?>
<?php endif; ?>