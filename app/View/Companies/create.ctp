<style type="text/css">
    .company-create-form {
        border: 1px solid #ddd;
        padding: 10px;
        margin: 10px;
    }

    .company-create-form form .input.text {
        height: 40px;
        /*border: 1px solid red;*/
    }

    .company-create-form form input[type="text"] {
        float: right;
        width: 200px;
    }

    .company-create-form form label {
        float: left;
        width: 70px;
        line-height: 30px;
    }
</style>

<h1>Create Company Profile</h1>

<div class="company-create-form clearfix">
    <?php
    echo $this->Form->create('Company', array(
        'action' => 'save'
    ));

    echo $this->Form->input('Company.name');
    ?>

    <h3>Address:</h3>
    <?php
    echo $this->Form->input('Address.line1');
    echo $this->Form->input('Address.line2');
    echo $this->Form->input('Address.city');
    echo $this->Form->input('Address.state');
    echo $this->Form->input('Address.zip');

    echo $this->Form->submit('Save');
    echo $this->Form->end();
    ?>
</div>