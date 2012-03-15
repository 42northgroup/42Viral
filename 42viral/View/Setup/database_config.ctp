<style type="text/css">
    /*
    label {
        display: inline-block;
    }

    input[type='text'] {
        width: 98%;
    }
    */

    .config-chkbx-label {
        display: inline-block;
        width: 200px;
    }


    .radio-container label {
        display: inline-block;
        width: 200px;
    }

    .config-txt-label {
        width: 100px;
        display: inline-block;
    }

    .config-field {
        margin: 5px 0px;
    }

    .config-field-desc {
        float: left; 
        width: 400px;
        margin-left: 10px;
    }

    .form-sub-box .separator {
        margin: 20px 0px;
    }

    .form-sub-box .line-separator {
        border-bottom: 1px solid #ddd;
        margin: 20px 0px;
    }

    .form-help {
        border: 1px solid #f0f0f0;
        background: #fff;
        padding: 3px;
        margin: 0 4px 0 1px;
        border-radius: 3px;
    }

    .form-box {
        padding: 8px;
        margin: 0 0 8px;
        background: #e2e2e2;
        border-radius: 4px;
    }

    .form-sub-box {
        background-color: #f5f5f5;
        padding: 10px;
        margin: 5px;
    }

    .form-sub-box .title-help {
        margin-bottom: 10px;
    }

    .form-sub-box .title-help h2 {
        display: inline-block;
        margin-right: 20px;
    }
</style>

<?php
echo $this->element('Navigation' .DS. 'local', array(
    'section' => 'configuration',
    'class' => 'config'
));

echo $this->Form->create(null, array('url' => $this->here));
?>

<div class="form-box">
    <h1>Database Configuration</h1>

    <div class="form-sub-box">
        <div class="title-help">
            <h2>Drvier</h2> Database driver to use. Valid options are as follows:
        </div>

        <?php $i = 0; ?>
        <?php foreach($db_drivers as $tempDbDriver): ?>
            <div class="radio-container">
                <?php
                echo $this->Form->radio(null, 
                    array(
                        $tempDbDriver['value'] => $tempDbDriver['label']
                    ),

                    array(
                        'id' => 'db_driver_' . strtolower($tempDbDriver['label']),
                        'checked' => ($i++ == 0)? true: false,
                        'name' => 'data[DataSource.default.datasource]',
                        'legend' => false
                    )
                );
                ?>
                
                <?php echo $tempDbDriver['description']; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-sub-box">
        <div class="config-field">
            <?php
            echo $this->Form->checkbox(null, array(
                'id' => 'db_persistent',
                'name' => 'data[DataSource.default.persistent]',
                'checked' => false
            ));
            ?>

            <label for="db_persistent" class="config-chkbx-label">Persistent</label>
            Determines whether or not the database should use a persistent connection
        </div>

        <div class="line-separator"></div>

        <?php foreach($txt_fields as $tempTxtField): ?>
            <div class="config-field clearfix">
                <label for="db_<?php echo strtolower($tempTxtField['label']); ?>"
                       class="config-txt-label" style="float: left;"><?php echo $tempTxtField['label']; ?></label>

                <?php
                echo $this->Form->text(null, array(
                    'name' => 'data[DataSource.default.' .strtolower($tempTxtField['label']). ']',
                    'value' => $tempTxtField['value'],
                    'id' => 'db_' . strtolower($tempTxtField['label']),
                    'style' => 'float: left;'
                ));
                ?>

                <div class="config-field-desc">
                    <?php echo $tempTxtField['description']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>


<div class="form-box">
    <h1>Test Database Configuration</h1>

    <div class="form-sub-box">
        <div class="title-help">
            <h2>Drvier</h2> Database driver to use. Valid options are as follows:
        </div>

        <?php $i = 0; ?>
        <?php foreach($db_drivers as $tempDbDriver): ?>
            <div class="radio-container">
                <?php
                echo $this->Form->radio(null,
                    array(
                        $tempDbDriver['value'] => $tempDbDriver['label']
                    ),

                    array(
                        'id' => 'db_driver_' . strtolower($tempDbDriver['label']),
                        'checked' => ($i++ == 0)? true: false,
                        'name' => 'data[DataSource.test.datasource]',
                        'legend' => false
                    )
                );
                ?>

                <?php echo $tempDbDriver['description']; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="form-sub-box">
        <div class="config-field">
            <?php
            echo $this->Form->checkbox(null, array(
                'id' => 'db_persistent_test',
                'name' => 'data[DataSource.test.persistent]',
                'checked' => false
            ));
            ?>

            <label for="db_persistent_test" class="config-chkbx-label">Persistent</label>
            Determines whether or not the database should use a persistent connection
        </div>

        <div class="line-separator"></div>

        <?php foreach($txt_fields as $tempTxtField): ?>
            <div class="config-field clearfix">
                <label for="db_<?php echo strtolower($tempTxtField['label']); ?>"
                       class="config-txt-label" style="float: left;"><?php echo $tempTxtField['label']; ?></label>

                <?php
                echo $this->Form->text(null, array(
                    'name' => 'data[DataSource.test.' .strtolower($tempTxtField['label']). ']',
                    'value' => $tempTxtField['test_value'],
                    'id' => 'db_' . strtolower($tempTxtField['label']),
                    'style' => 'float: left;'
                ));
                ?>

                <div class="config-field-desc">
                    <?php echo $tempTxtField['description']; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<?php
echo $this->Form->submit('Save Configuration', array(
    'before' => $this->Form->input('Control.next_step', array(
        'type' => 'checkbox',
        'div' => false,
        'style' => 'margin-right: 6px;',
        'checked' => true,
        'label' => array('style' => 'display:inline; margin-right: 6px;')
    ))
)); 
?>

<?php echo $this->Form->end(); ?>