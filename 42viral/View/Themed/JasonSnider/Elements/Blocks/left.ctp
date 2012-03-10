<ul class="side-navigation">
    <li><a href="/blog/the-incessant-ramblings-of-an-over-caffeinated-web-developer">Blog</a></li>
    <li><a href="/pages">Pages</a></li>
</ul>

<?php if($this->Session->check('Auth.User.id')): ?>
    <?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'contents'); ?>
<?php endif; ?>