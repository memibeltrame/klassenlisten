<?php
$hide = "hide";
$hideOnLoad = "";
if(!empty($showFormOnLoad)){
    $hide = "";
    $hideOnLoad = "hide";
}
 if($is_admin){?>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Vorname
    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $vorname ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="60" name="vorname" value="<?php echo $vorname ;?>" >
    </span>
</div>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Name
    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $name ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="60" name="name" value="<?php echo $name ;?>" >
    </span>
</div>
<?php } ?>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Email

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <a href="mailto:<?php echo $email ;?>"><?php echo $email ;?></a>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="60" name="email" value="<?php echo $email ;?>" >
    </span>
</div>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Handynummer

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <a href="tel:<?php echo $mobile ;?>"><?php echo $mobile ;?></a>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="20" name="mobile" value="<?php echo $mobile ;?>" >
    </span>
</div>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Adresse

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $adresse ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="20" name="adresse" value="<?php echo $adresse ;?>" >
    </span>
</div>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    PLZ

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $plz  ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="20" name="plz" value="<?php echo $plz ;?>" >
    </span>
</div>
<div class="row form-group">
    <span class="col-md-2  col-xs-12 combo-label">
    Ort

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $ort ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control"  maxlength="20" name="ort" value="<?php echo $ort ;?>" >
    </span>
</div>
<?php if (!empty($fachZeigen)): ?>
    <div class="row form-group  ">
        <span class="col-md-2 col-xs-12 combo-label">
        Unterrichtsfach

        </span>
        <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
            <?php echo $fach ;?>
        </span>
            <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
            <input type="text" class="form-control" name="fach"  maxlength="40" value="<?php echo $fach ;?>">
        </span>
    </div>
<?php endif ?>


<div class="row form-group  ">
    <span class="col-md-2 col-xs-12 combo-label">
    Beruf

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $beruf ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control" name="beruf"  maxlength="40" value="<?php echo $beruf ;?>">
    </span>
</div>

<div class="row form-group  ">
    <span class="col-md-2 col-xs-12 combo-label">
    Arbeitgeber

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $arbeitgeber ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control" maxlength="40" name="arbeitgeber" value="<?php echo $arbeitgeber ;?>">
    </span>
</div>
<?php if($is_admin){?>


<div class="row form-group  ">
    <span class="col-md-2 col-xs-12 combo-label">
    Zusatzinfo

    </span>
    <span class="col-md-4  col-xs-12 formElement combo-label <?php echo $hideOnLoad ;?>">
        <?php echo $zusatzinfo ;?>
    </span>
    <span class="col-md-4  col-xs-12 formElement <?php echo $hide ;?>">
        <input type="text" class="form-control" maxlength="40" name="zusatzinfo" value="<?php echo $zusatzinfo ;?>">
    </span>
</div>
<?php } ?>