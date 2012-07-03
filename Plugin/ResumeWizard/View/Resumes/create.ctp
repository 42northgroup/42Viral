<div class="row">
    <div class="two-thirds column alpha">
        <?php

        echo $this->Form->create(
            'Resume',
            array(
                'class'=>'responsive'
            )
        );

        echo $this->Form->input('model', array('value'=>$model));

        echo $this->Form->input('model_id', array('value'=>$modelId, 'type'=>'text'));

        echo $this->Form->input('label');

        echo $this->Form->input('title');

        echo $this->Form->input('summary');

        echo $this->Form->input('summary_items');

        echo $this->Form->input('core_competencies_label', array('value'=>'Core Competencies'));

        echo $this->Form->input('core_competencies');

        echo $this->Form->input('skills_label', array('value'=>'Certifications / Technical Proficiencies'));

        echo $this->Form->input('skills');

        echo $this->Form->input('experience_label', array('value'=>'Professional Experience'));

        echo $this->Form->input('education_label', array('value'=>'Education'));

        echo $this->Form->submit();

        echo $this->Form->end();
        ?>
    </div>
    <div class="one-third column omega">
    <?php
        echo $this->element('ResumeWizard.menus');
    ?>
    </div>
</div>