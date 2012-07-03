<?php
App::uses('Scrub', 'Lib');
App::uses('Utility', 'Lib');
?>
<style type="text/css">
    div.resume-block{
        padding:0 0 1em;
    }
</style>

<div class="row">
    <div class="two-thirds column alpha">

        <div class="resume-block">
            <div><?php echo $resume['Person']['name']; ?></div>
            <div><?php echo $resume['Person']['Address'][0]['full_address']; ?></div>
            <div>
                <?php foreach($resume['Person']['PhoneNumber'] as $key=>$phone): ?>
                    <span><?php echo ($key>0?' / ':null) . $phone['label']; ?>: </span>
                    <span><?php echo Handy::phoneNumber($phone['phone_number']); ?></span>
                <?php endforeach; ?>
            </div>
            <div>
                <span>Email: </span>
                <span><?php echo $resume['Person']['EmailAddress'][0]['email_address']; ?></span>
            </div>
        </div>

        <h1><?php echo $resume['Resume']['title']; ?></h1>
        <div class="resume-block">
            <?php echo Scrub::htmlStrict(Utility::markdown($resume['Resume']['summary'])); ?>
        </div>
        <div class="resume-block">
            <?php echo Scrub::htmlStrict(Utility::markdown($resume['Resume']['summary_items'])); ?>
        </div>
        <h2><?php echo $resume['Resume']['core_competencies_label']; ?></h2>
        <div class="resume-block">
            <?php echo Scrub::htmlStrict(Utility::markdown($resume['Resume']['core_competencies'])); ?>
        </div>
        <h2><?php echo $resume['Resume']['skills_label']; ?></h2>
        <div class="resume-block">
            <?php echo Scrub::htmlStrict(Utility::markdown($resume['Resume']['skills'])); ?>
        </div>
        <h2><?php echo $resume['Resume']['experience_label']; ?></h2>
        <div class="resume-block"></div>
        <h2><?php echo $resume['Resume']['education_label']; ?></h2>
        <div class="resume-block"></div>
    </div>
    <div class="one-third column omega"></div>
</div>
<?php
