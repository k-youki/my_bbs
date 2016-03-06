<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postTable->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postTable->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Post Table'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="postTable form large-9 medium-8 columns content">
    <?= $this->Form->create($postTable) ?>
    <fieldset>
        <legend><?= __('Edit Post Table') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('contents');
            echo $this->Form->input('image');
            echo $this->Form->input('date');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
