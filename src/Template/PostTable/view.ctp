<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Post Table'), ['action' => 'edit', $postTable->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Post Table'), ['action' => 'delete', $postTable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postTable->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Post Table'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Post Table'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="postTable view large-9 medium-8 columns content">
    <h3><?= h($postTable->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($postTable->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Contents') ?></th>
            <td><?= h($postTable->contents) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><?= h($postTable->image) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($postTable->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Date') ?></th>
            <td><?= h($postTable->date) ?></td>
        </tr>
    </table>
</div>
